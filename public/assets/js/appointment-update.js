// Sayfa yüklendiğinde otomatik olarak çalıştır
document.addEventListener('DOMContentLoaded', function () {
    const citySelect = document.getElementById('city');
    const cityId = citySelect.value; // Formdan otomatik olarak mevcut city ID'sini al

    if (cityId) {
        // İlçeleri yükle
        loadDistricts(cityId);
    }

    const dateInput = document.getElementById('date');
    const selectedDate = document.getElementById('selected_date').value;
    dateInput.value = selectedDate;
});

// Şehir seçildiğinde ilçeleri yükler
document.getElementById('city').addEventListener('change', function () {
    const cityId = this.value;
    loadDistricts(cityId);
});

// İlçeleri yükleme fonksiyonu
function loadDistricts(cityId) {
    const districtSelect = document.getElementById('district');

    // İlçe dropdown'ını temizle
    districtSelect.innerHTML = '<option value="">İlçe Seçiniz</option>';

    if (cityId) {
        fetch(`/get-districts?city_id=${cityId}`)
            .then(response => response.json())
            .then(data => {
                if (data.districts) {
                    data.districts.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.district_id;
                        option.textContent = district.district_name;
                        districtSelect.appendChild(option);
                    });

                    // Gizli input'tan seçili ilçeyi al
                    const selectedDistrictId = document.getElementById('selected_district_id').value;
                    if (selectedDistrictId) {
                        districtSelect.value = selectedDistrictId; // Seçili ilçeyi gizli input'tan alarak ayarla

                        // Seçilen ilçenin hastanelerini yükle
                        loadHospitals(selectedDistrictId);
                    }
                } else {
                    toastr.error('İlçeler bulunamadı.');
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
    }
}

// İlçe değiştiğinde hastaneleri yükler
document.getElementById('district').addEventListener('change', function () {
    const districtId = this.value;
    loadHospitals(districtId);
});

// Hastaneleri yükleme fonksiyonu
function loadHospitals(districtId) {
    const hospitalSelect = document.getElementById('hospital');
    hospitalSelect.innerHTML = '<option value="">Hastane Seçin</option>';

    if (districtId) {
        fetch(`/get-hospital?district_id=${districtId}`)
            .then(response => response.json())
            .then(data => {
                if (data.hospitals && data.hospitals.length > 0) {
                    let defaultHospitalSelected = false;

                    // Gizli input'tan hastane adını al
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

                        // Eğer hastane adı gizli inputtaki isimle eşleşiyorsa, bu hastaneyi otomatik seçili yap
                        if (!defaultHospitalSelected && hospital.address_name === selectedHospitalName) {
                            hospitalSelect.value = hospital.address_id;
                            defaultHospitalSelected = true;
                            loadDoctors(hospital.address_id);
                        }
                    });
                } else {
                    toastr.error('Bu ilçede hastane bulunamadı.');
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
    }
}

// Hastaneyi seçtikten sonra doktorları yükleme
document.getElementById('hospital').addEventListener('change', function () {
    const addressId = this.value;
    loadDoctors(addressId);
});


// Doktorları yükleme fonksiyonu
function loadDoctors(addressId) {
    const doctorSelect = document.getElementById('doctor');
    const subCategory = document.getElementById('sub-category').value;

    doctorSelect.innerHTML = '<option value="">Doktor Seçin</option>';

    if (addressId && subCategory) {
        fetch(`/get-doctor?address_id=${addressId}&specialties_id=${subCategory}`)
            .then(response => response.json())
            .then(data => {
                if (data.doctors && data.doctors.length > 0) {
                    let defaultDoctorSelected = false;

                    // Gizli input'tan seçili doktoru al
                    const selectedDoctorId = document.getElementById('selected_doctor_id').value;

                    data.doctors.forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor.doctor_id;
                        option.textContent = `Dr. ${doctor.doctor_name} ${doctor.doctor_surname}`;
                        doctorSelect.appendChild(option);

                        // Eğer doktor ID gizli inputtaki ID ile eşleşiyorsa, bu doktoru otomatik seçili yap
                        if (!defaultDoctorSelected && doctor.doctor_id == selectedDoctorId) {
                            doctorSelect.value = doctor.doctor_id;
                            defaultDoctorSelected = true;
                            loadAvailableTimes(doctor.doctor_id);
                        }
                    });
                } else {
                    toastr.error('Bu kategorilerde doktor bulunamadı.');
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
    }
}


document.getElementById('date').addEventListener('change', function () {
    const doctorId = document.getElementById("doctor").value;

    // Seçilen saati sıfırla (gizli input'u temizle)
    document.getElementById('selected_time').value = '';

    loadAvailableTimes(doctorId);
});

function loadAvailableTimes(doctorId) {
    const timeSelect = document.getElementById('time');
    timeSelect.innerHTML = '<option value="">Saat Seçin</option>'; // Saat seçeneklerini temizle
    const selectedDate = document.getElementById('date').value;

    // Gizli input'tan seçili saati al
    const selectedTime = document.getElementById('selected_time').value;

    // Fetch ile doktorun çalışma saatlerini getir
    fetch(`/get-doctor-schedule?doctor_id=${doctorId}&date=${selectedDate}`)
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                // Eğer mesaj varsa alert ile göster
                toastr.info(data.message);  // Mesajı alert ile göster
                return;
            }

            if (data.times && data.times.length > 0) {
                let defaultTimeSelected = false;

                data.times.forEach(time => {
                    const option = document.createElement('option');
                    option.value = time.time;  // Saat dilimini option value'si olarak ekliyoruz
                    option.textContent = time.time;  // Saat dilimini option metni olarak ekliyoruz

                    if (time.status === true) {
                        option.disabled = true;  // Bu saat seçilemez olacak
                        option.classList.add('disabled-time');  // Kırmızı renk için sınıf ekliyoruz
                    }

                    // Eğer gizli inputtaki değerle eşleşiyorsa, bu saati otomatik seçili yap
                    if (!defaultTimeSelected && time.time === selectedTime) {
                        option.selected = true;
                        defaultTimeSelected = true;
                    }

                    timeSelect.appendChild(option);  // Yeni option'ı time select öğesine ekliyoruz
                });
            } else {
                toastr.error('Bu tarihte doktorun uygun saatleri bulunmamaktadır.');
            }
        })
        .catch(error => {
            console.error('Hata:', error);
            toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
        });
}
