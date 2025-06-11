document.addEventListener('DOMContentLoaded', function () {
    const category = document.getElementById('category');
    const subCategory = document.getElementById('sub-category');
    const city = document.getElementById('city');
    const district = document.getElementById('district');
    const hospital = document.getElementById('hospital');
    const doctor = document.getElementById('doctor');
    const date = document.getElementById('date');
    const time = document.getElementById('time');

    // Başlangıçta tüm alanları devre dışı bırak
    const disableAll = () => {
        if (subCategory) subCategory.disabled = true;
        if (city) city.disabled = true;
        if (district) district.disabled = true;
        if (hospital) hospital.disabled = true;
        if (doctor) doctor.disabled = true;
        if (date) date.disabled = true;
        if (time) time.disabled = true;
    };

    // Sayfa yüklendiğinde tüm alanları devre dışı bırak
    disableAll();

    // Bölüm seçimi
    if (category) {
        category.addEventListener('change', function () {
            if (category.value !== "") {
                // Bölüm seçildiyse Poliklinik aktif hale gelir
                subCategory.disabled = false;
                subCategory.focus();
                // Şehir ve sonrasındaki adımları sıfırla
                city.value = '';
                district.value = '';
                hospital.value = '';
                doctor.value = '';
                date.value = '';
                time.value = '';
                disableAllFieldsAfter(subCategory);
            } else {
                disableAll(); // Bölüm seçilmediyse tüm alanları devre dışı bırak
            }
        });
    }

    // Alt Kategori (Poliklinik) seçimi
    if (subCategory) {
        subCategory.addEventListener('change', function () {
            if (subCategory.value !== "") {
                city.disabled = false;
                city.value = "";
                city.focus();
                // İlçe, Hastane, Doktor, Tarih, Saat sıfırlanır
                district.value = '';
                hospital.value = '';
                doctor.value = '';
                date.value = '';
                time.value = '';
                disableAllFieldsAfter(city);
            } else {
                city.disabled = true;
                district.disabled = true;
                hospital.disabled = true;
                doctor.disabled = true;
                date.disabled = true;
                time.disabled = true;
            }
        });
    }

    // Şehir seçimi
    if (city) {
        city.addEventListener('change', function () {
            if (city.value !== "") {
                district.disabled = false;
                district.focus();
                hospital.value = '';
                doctor.value = '';
                date.value = '';
                time.value = '';
                disableAllFieldsAfter(district);
            } else {
                district.disabled = true;
                hospital.disabled = true;
                doctor.disabled = true;
                date.disabled = true;
                time.disabled = true;
            }
        });
    }

    // İlçe seçimi
    if (district) {
        district.addEventListener('change', function () {
            if (district.value !== "") {
                hospital.disabled = false;
                hospital.focus();
                doctor.value = '';
                date.value = '';
                time.value = '';
                disableAllFieldsAfter(hospital);
            } else {
                hospital.disabled = true;
                doctor.disabled = true;
                date.disabled = true;
                time.disabled = true;
            }
        });
    }

    // Hastane seçimi
    if (hospital) {
        hospital.addEventListener('change', function () {
            if (hospital.value !== "") {
                doctor.disabled = false;
                doctor.focus();
                date.value = '';
                time.value = '';
                disableAllFieldsAfter(doctor);
            } else {
                doctor.disabled = true;
                date.disabled = true;
                time.disabled = true;
            }
        });
    }

    // Doktor seçimi
    if (doctor) {
        doctor.addEventListener('change', function () {
            if (doctor.value !== "") {
                date.disabled = false;
                date.focus();
                time.value = '';
                disableAllFieldsAfter(date);
            } else {
                date.disabled = true;
                time.disabled = true;
            }
        });
    }

    // Tarih seçimi
    if (date) {
        date.addEventListener('change', function () {
            if (date.value !== "") {
                time.disabled = false;
                time.focus();
            } else {
                time.disabled = true;
            }
        });
    }

    // Bütün sonraki alanları devre dışı bırakma
    function disableAllFieldsAfter(field) {
        const fields = [city, district, hospital, doctor, date, time];
        const startIndex = fields.indexOf(field);
        for (let i = startIndex + 1; i < fields.length; i++) {
            if (fields[i]) fields[i].disabled = true;
            if (fields[i]) fields[i].value = '';  // Sıfırlama
        }
    }
});


document.getElementById('city').addEventListener('change', function() {
    const cityId = this.value;
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
                } else {
                    toastr.error('İlçeler bulunamadı.');
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
    }
});




document.getElementById('district').addEventListener('change', function () {
    const districtId = this.value; // İlçe ID'sini alıyoruz
    const hospitalSelect = document.getElementById('hospital'); // Hastane dropdown'ını seçiyoruz

    // Hastane dropdown'ını temizle
    hospitalSelect.innerHTML = '<option value="">Hastane Seçin</option>';

    // Eğer bir ilçede seçim yapıldıysa
    if (districtId) {
        fetch(`/get-hospital?district_id=${districtId}`)
            .then(response => response.json())
            .then(data => {
                if (data.hospitals && data.hospitals.length > 0) {
                    data.hospitals.forEach(hospitalData => {
                        const hospital = hospitalData.hospital; // Hastane bilgileri
                        const randomFloor = hospitalData.random_floor; // Rastgele seçilen kat bilgisi

                        // Rastgele kat bilgisi mevcut mu?
                        const blockName = randomFloor?.block_name || 'Blok bilgisi yok';
                        const roomNumber = randomFloor?.room_number || 'Oda numarası yok';
                        document.getElementById('floor_id').value = randomFloor.id;

                        // Yeni bir <option> oluştur ve dropdown'a ekle
                        const option = document.createElement('option');
                        option.value = hospital.address_id; // Hastane ID'sini value olarak koyuyoruz
                        option.textContent = `${hospital.address_name} (${blockName}, ${roomNumber})`;
                        hospitalSelect.appendChild(option);
                    });
                } else {
                    // Eğer hastane bulunmazsa uyarı mesajı ver
                    toastr.error('Bu ilçede hastane bulunamadı.');
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
    }
});


document.getElementById('hospital').addEventListener('change', function () {
    const $addressId = this.value; // İlçe ID'sini alıyoruz
    const $sub_category = document.getElementById('sub-category').value;
    const doctorSelect = document.getElementById('doctor'); // Doktor dropdown'ını seçiyoruz

    // Doktor dropdown'ını temizle
    doctorSelect.innerHTML = '<option value="">Doktor Seçin</option>';

    // Eğer hem address_id hem de specialties_id varsa
    if ($addressId && $sub_category) {
        fetch(`/get-doctor?address_id=${$addressId}&specialties_id=${$sub_category}`)
            .then(response => response.json())
            .then(data => {
                if (data.doctors && data.doctors.length > 0) {
                    data.doctors.forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor.doctor_id; // Doctor ID'sini value olarak ekliyoruz
                        option.textContent = `Dr. ${doctor.doctor_name} ${doctor.doctor_surname}`; // Doktor adını option'un içeriği olarak ekliyoruz
                        doctorSelect.appendChild(option); // Yeni option'ı select öğesine ekliyoruz
                    });
                } else {
                    // Eğer doktor bulunmazsa uyarı mesajı ver
                    toastr.error('Aradığınız kategorilerde doktor bulunamadı.');
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
    }
});

document.getElementById('date').addEventListener('change', function() {
    const selectedDate = this.value;  // Kullanıcının seçtiği tarih
    const doctorId = document.getElementById('doctor').value;  // Dinamik olarak doktor ID'sini alıyoruz
    const isScheduleUpdated = false;

    if (selectedDate && doctorId) {
        // `time` dropdown'ını temizle
        const timeSelect = document.getElementById('time');
        timeSelect.innerHTML = '<option value="">Saat Seçin</option>'; // İlk olarak saat seçeneklerini sıfırlıyoruz

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
                    data.times.forEach(time => {
                        const option = document.createElement('option');
                        option.value = time.time;  // Saat dilimini option value'si olarak ekliyoruz
                        option.textContent = time.time;  // Saat dilimini option metni olarak ekliyoruz
                        if (time.status === true) {
                            option.disabled = true;  // Bu saat seçilemez olacak
                            option.classList.add('disabled-time');  // Kırmızı renk için sınıf ekliyoruz
                        }
                        timeSelect.appendChild(option);  // Yeni option'ı time select öğesine ekliyoruz
                    });
                }else {
                    toastr.error('Bu tarihte doktorun uygun saatleri bulunmamaktadır.');
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
    }
});



// Saat için
document.getElementById('time').addEventListener('change', function() {
    const timeName = this.options[this.selectedIndex].text; // Seçilen saat adı

    if (timeName) {
        // Saat bilgisi sağ tarafa ekleniyor
        addOrUpdateDynamicInfo('saat', 'Saat: ', timeName, 'bi-clock');
    }
});

document.getElementById('hospital').addEventListener('change', function() {
    const hospitalName = this.options[this.selectedIndex].text; // Seçilen hastane adı

    if (hospitalName) {
        // Hastane bilgisi sağ tarafa ekleniyor
        addOrUpdateDynamicInfo('hastane', 'Hastane: ', hospitalName, 'bi-hospital');
        removeDynamicInfo('saat');
        removeDynamicInfo('doktor');
        removeDynamicInfo('randevu-saat');
    }
});

document.getElementById('doctor').addEventListener('change', function() {
    const doctorName = this.options[this.selectedIndex].text; // Seçilen doktor adı

    if (doctorName) {
        // Doktor bilgisi sağ tarafa ekleniyor
        addOrUpdateDynamicInfo('doktor', 'Doktor: ', doctorName, 'bi-person-vcard');
        removeDynamicInfo('saat');
        removeDynamicInfo('randevu-saat');

    }
});

document.getElementById('district').addEventListener('change', function() {
    const districtName = this.options[this.selectedIndex].text; // Seçilen ilçe adı

    if (districtName) {
        // İlçe bilgisi sağ tarafa ekleniyor
        addOrUpdateDynamicInfo('ilce', 'İlçe: ', districtName, 'bi-geo-alt-fill');
        removeDynamicInfo('saat');
        removeDynamicInfo('hastane');
        removeDynamicInfo('doktor');
        removeDynamicInfo('randevu-saat');
    }
});

const timeSelect = document.getElementById('date');
timeSelect.addEventListener('change', function() {
    const selectedDate = this.value;
    addOrUpdateDynamicInfo('randevu-saat', 'Randevu Tarihi: ', selectedDate, 'bi-calendar-event');

    removeDynamicInfo('saat');
});

handleSelectChange(document.getElementById('category'), 'bolum', 'Bölüm: ', 'bi-briefcase');
handleSelectChange(document.getElementById('sub-category'), 'poliklinik', 'Poliklinik: ', 'bi-journal-medical');
handleSelectChange(document.getElementById('city'), 'sehir', 'Şehir: ', 'bi-building');

// Genel seçici fonksiyon (data-name kullanımı ile)
function handleSelectChange(selectElement, id, labelText, iconClass) {
    if (selectElement) {
        selectElement.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const dataName = selectedOption.getAttribute('data-name');
            // Eğer Poliklinik veya Bölüm değişirse, önceki seçimleri sıfırla
            if (id === 'poliklinik') {
                // Poliklinik değiştiğinde Şehir ve İlçe bilgilerini sil
                removeDynamicInfo('ilce');
                removeDynamicInfo('saat');
                removeDynamicInfo('hastane');
                removeDynamicInfo('doktor');
                removeDynamicInfo('randevu-saat');
            }

            // Eğer Bölüm değişirse, Bölüm'e ait bilgiyi temizle
            if (id === 'bolum') {
                removeDynamicInfo('bolum');
                removeDynamicInfo('poliklinik');
                removeDynamicInfo('saat');
                removeDynamicInfo('hastane');
                removeDynamicInfo('doktor');
                removeDynamicInfo('randevu-saat');
            }
            if (id === 'sehir') {
                removeDynamicInfo('saat');
                removeDynamicInfo('hastane');
                removeDynamicInfo('doktor');
                removeDynamicInfo('randevu-saat');
            }
            if (dataName) {
                addOrUpdateDynamicInfo(id, labelText, dataName, iconClass);
            }

        });
    }
}

// Dinamik bilgiyi ekleyen ya da güncelleyen fonksiyon
function addOrUpdateDynamicInfo(id, labelText, valueText, iconClass) {
    const dynamicInfo = document.getElementById('dynamic-info');
    let existingSection = document.getElementById(id);

    if (existingSection) {
        // Existing section found, update the value if it's different
        const valueDiv = existingSection.querySelector('.fw-bold.fs-6'); // Find the div containing the value
        if (valueDiv && valueDiv.textContent !== valueText) {
            valueDiv.textContent = valueText || 'Seçiniz';
        }
    } else {
        // Create a new section with modern Bootstrap styles
        const section = document.createElement('div');
        // Use Bootstrap classes for layout and spacing
        section.classList.add('d-flex', 'align-items-center', 'mb-3', 'slide-in-right');
        section.id = id; // Set the unique ID

        // Create the icon container with background and rounded shape
        const iconContainer = document.createElement('div');
        // Use Bootstrap classes for styling (example using primary color, adjust as needed)
        iconContainer.classList.add('bg-primary', 'bg-opacity-10', 'text-primary', 'rounded-circle', 'p-2', 'me-3', 'd-flex', 'align-items-center', 'justify-content-center');
        iconContainer.style.width = '48px'; // Set fixed size
        iconContainer.style.height = '48px';

        // Create the icon element using Bootstrap Icons classes
        const icon = document.createElement('i');
        // Assume iconClass already contains the Bootstrap Icon class like 'bi-building'
        icon.classList.add('bi', iconClass, 'fs-3'); // Add Bootstrap Icon class and size

        // Append icon to its container
        iconContainer.appendChild(icon);

        // Create a div for label and value
        const infoContent = document.createElement('div');

        // Create label with Bootstrap classes
        const label = document.createElement('div');
        label.classList.add('text-muted', 'small');
        label.textContent = labelText; // Set label text

        // Create value with Bootstrap classes
        const value = document.createElement('div');
        value.classList.add('fw-bold', 'fs-6');
        value.textContent = valueText || 'Seçiniz'; // Set value text or default

        // Append label and value to info content div
        infoContent.appendChild(label);
        infoContent.appendChild(value);

        // Append icon container and info content to the main section
        section.appendChild(iconContainer);
        section.appendChild(infoContent);

        // Append the new section to the dynamic-info div
        dynamicInfo.appendChild(section);
    }
}

// Dinamik bilgiyi sağdan silen fonksiyon (stil değişikliklerinden etkilenmez)
function removeDynamicInfo(id) {
    const dynamicInfo = document.getElementById('dynamic-info');
    const existingSection = document.getElementById(id);

    if (existingSection) {
        // Remove the section element with the given ID
        dynamicInfo.removeChild(existingSection);
    }
}

