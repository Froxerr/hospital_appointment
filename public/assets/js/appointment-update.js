// Loading göstergesi için stil
const loadingStyle = `
    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        body.dark-mode .loading-overlay {
            background: rgba(0, 0, 0, 0.8);
        }
        body.dark-mode .loading-spinner {
            border-color: #2d2d2d;
            border-top-color: var(--primary-color);
        }
    </style>
`;

document.head.insertAdjacentHTML('beforeend', loadingStyle);

// Loading göstergesi fonksiyonları
function showLoading() {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay';
    overlay.innerHTML = '<div class="loading-spinner"></div>';
    document.body.appendChild(overlay);
}

function hideLoading() {
    const overlay = document.querySelector('.loading-overlay');
    if (overlay) {
        overlay.remove();
    }
}

// Form doğrulama fonksiyonu
function validateForm() {
    const requiredFields = ['category', 'sub_category', 'city', 'district', 'hospital', 'doctor', 'date', 'time'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const element = document.getElementById(field === 'sub_category' ? 'sub-category' : field);
        if (!element.value) {
            isValid = false;
            toastr.error(`Lütfen ${element.previousElementSibling.textContent} alanını doldurun.`);
        }
    });
    
    return isValid;
}

// Sayfa yüklendiğinde otomatik olarak çalıştır
document.addEventListener('DOMContentLoaded', async function () {
    showLoading(); // Sayfa yüklenirken loading göster
    
    try {
        // Tarih sınırlamalarını ayarla
        const dateInput = document.getElementById('date');
        const today = new Date();
        const maxDate = new Date();
        maxDate.setMonth(maxDate.getMonth() + 3);

        dateInput.min = today.toISOString().split('T')[0];
        dateInput.max = maxDate.toISOString().split('T')[0];

        const citySelect = document.getElementById('city');
        const cityId = citySelect.value;

        if (cityId) {
            await loadDistricts(cityId);
        }

        const selectedDate = document.getElementById('selected_date').value;
        dateInput.value = selectedDate;

        // Form submit olayını dinle
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateForm()) {
                Swal.fire({
                    title: 'Randevu Güncellenecek',
                    text: 'Randevu bilgilerinizi güncellemek istediğinizden emin misiniz?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Evet, Güncelle',
                    cancelButtonText: 'İptal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading();
                        form.submit();
                    }
                });
            }
        });
    } catch (error) {
        console.error('Hata:', error);
        toastr.error('Sayfa yüklenirken bir hata oluştu.');
    } finally {
        hideLoading(); // Tüm işlemler tamamlandığında loading'i kaldır
    }
});

// Şehir seçildiğinde ilçeleri yükler
document.getElementById('city').addEventListener('change', function () {
    const cityId = this.value;
    showLoading();
    loadDistricts(cityId);
});

// İlçeleri yükleme fonksiyonu
async function loadDistricts(cityId) {
    const districtSelect = document.getElementById('district');
    districtSelect.innerHTML = '<option value="">İlçe Seçiniz</option>';

    if (cityId) {
        try {
            const response = await fetch(`/get-districts?city_id=${cityId}`);
            const data = await response.json();

            if (data.districts) {
                data.districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.district_id;
                    option.textContent = district.district_name;
                    districtSelect.appendChild(option);
                });

                const selectedDistrictId = document.getElementById('selected_district_id').value;
                if (selectedDistrictId) {
                    districtSelect.value = selectedDistrictId;
                    loadHospitals(selectedDistrictId);
                }
            } else {
                toastr.error('İlçeler bulunamadı.');
            }
        } catch (error) {
            console.error('Hata:', error);
            toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
        } finally {
            hideLoading();
        }
    }
}

// İlçe değiştiğinde hastaneleri yükler
document.getElementById('district').addEventListener('change', function () {
    const districtId = this.value;
    showLoading();
    loadHospitals(districtId);
});

// Hastaneleri yükleme fonksiyonu
async function loadHospitals(districtId) {
    const hospitalSelect = document.getElementById('hospital');
    hospitalSelect.innerHTML = '<option value="">Hastane Seçin</option>';

    if (districtId) {
        try {
            const response = await fetch(`/get-hospital?district_id=${districtId}`);
            const data = await response.json();

            if (data.hospitals && data.hospitals.length > 0) {
                let defaultHospitalSelected = false;
                const selectedHospitalName = document.getElementById('selected_hospital_name').value;

                data.hospitals.forEach(hospitalData => {
                    const hospital = hospitalData.hospital;
                    const randomFloor = hospitalData.random_floor;

                    const blockName = randomFloor?.block_name || 'Blok bilgisi yok';
                    const roomNumber = randomFloor?.room_number || 'Oda numarası yok';
                    document.getElementById('floor_id').value = randomFloor.id;

                    const option = document.createElement('option');
                    option.value = hospital.address_id;
                    option.textContent = `${hospital.address_name} (${blockName}, ${roomNumber})`;
                    hospitalSelect.appendChild(option);

                    if (!defaultHospitalSelected && hospital.address_name === selectedHospitalName) {
                        hospitalSelect.value = hospital.address_id;
                        defaultHospitalSelected = true;
                        loadDoctors(hospital.address_id);
                    }
                });
            } else {
                toastr.error('Bu ilçede hastane bulunamadı.');
            }
        } catch (error) {
            console.error('Hata:', error);
            toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
        } finally {
            hideLoading();
        }
    }
}

// Hastaneyi seçtikten sonra doktorları yükleme
document.getElementById('hospital').addEventListener('change', function () {
    const addressId = this.value;
    showLoading();
    loadDoctors(addressId);
});

// Doktorları yükleme fonksiyonu
async function loadDoctors(addressId) {
    const doctorSelect = document.getElementById('doctor');
    const subCategory = document.getElementById('sub-category').value;

    doctorSelect.innerHTML = '<option value="">Doktor Seçin</option>';

    if (addressId && subCategory) {
        try {
            const response = await fetch(`/get-doctor?address_id=${addressId}&specialties_id=${subCategory}`);
            const data = await response.json();

            if (data.doctors && data.doctors.length > 0) {
                let defaultDoctorSelected = false;
                const selectedDoctorId = document.getElementById('selected_doctor_id').value;

                data.doctors.forEach(doctor => {
                    const option = document.createElement('option');
                    option.value = doctor.doctor_id;
                    option.textContent = `Dr. ${doctor.doctor_name} ${doctor.doctor_surname}`;
                    doctorSelect.appendChild(option);

                    if (!defaultDoctorSelected && doctor.doctor_id == selectedDoctorId) {
                        doctorSelect.value = doctor.doctor_id;
                        defaultDoctorSelected = true;
                        loadAvailableTimes(doctor.doctor_id);
                    }
                });
            } else {
                toastr.error('Bu kategorilerde doktor bulunamadı.');
            }
        } catch (error) {
            console.error('Hata:', error);
            toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
        } finally {
            hideLoading();
        }
    }
}

// Tarih değiştiğinde müsait saatleri yükle
document.getElementById('date').addEventListener('change', function () {
    const doctorId = document.getElementById("doctor").value;
    document.getElementById('selected_time').value = '';
    showLoading();
    loadAvailableTimes(doctorId);
});

// Müsait saatleri yükleme fonksiyonu
async function loadAvailableTimes(doctorId) {
    const timeSelect = document.getElementById('time');
    timeSelect.innerHTML = '<option value="">Saat Seçin</option>';
    const selectedDate = document.getElementById('date').value;
    const selectedTime = document.getElementById('selected_time').value;

    if (doctorId && selectedDate) {
        try {
            const response = await fetch(`/get-doctor-schedule?doctor_id=${doctorId}&date=${selectedDate}`);
            const data = await response.json();

            if (data.message) {
                toastr.info(data.message);
                return;
            }

            if (data.times && data.times.length > 0) {
                let defaultTimeSelected = false;

                data.times.forEach(time => {
                    const option = document.createElement('option');
                    option.value = time.time;
                    option.textContent = time.time;

                    if (time.status === true) {
                        option.disabled = true;
                        option.style.backgroundColor = '#ffebee';
                        option.style.color = '#d32f2f';
                        option.textContent += ' (Dolu)';
                    }

                    if (!defaultTimeSelected && time.time === selectedTime && !time.status) {
                        defaultTimeSelected = true;
                        option.selected = true;
                    }

                    timeSelect.appendChild(option);
                });
            } else {
                toastr.error('Bu tarih için uygun saat bulunamadı.');
            }
        } catch (error) {
            console.error('Hata:', error);
            toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
        } finally {
            hideLoading();
        }
    }
}
