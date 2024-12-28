document.addEventListener('DOMContentLoaded', function () {
    const logFilter = document.getElementById('logFilter');
    const logTableBody = document.getElementById('logTableBody');

    logFilter.addEventListener('change', function () {
        const filterValue = logFilter.value;

        // Tablodaki satırları alıyoruz
        const rows = Array.from(logTableBody.rows);

        // Boş satırları atlamak için
        const filteredRows = rows.filter(row => row.cells.length > 1); // Başlık satırını atlıyoruz

        // Satırlara animasyon sınıfını kaldırıyoruz
        filteredRows.forEach(row => {
            row.classList.remove('slide-in-fwd-center');
        });

        // Eğer "Onaylandı Olanları Göster" seçilmişse
        if (filterValue === 'status') {
            filteredRows.forEach(row => {
                const statusCell = row.cells[4]; // 'Randevu Durumu' sütununu alıyoruz (index 4)
                if (statusCell) {
                    const status = statusCell.innerText.trim();
                    // Eğer 'Onaylandı' değilse, o satırı gizli yapıyoruz
                    if (status !== 'Onaylandı') {
                        row.style.display = 'none';  // 'İptal' olanları gizle
                    } else {
                        row.style.display = '';  // 'Onaylandı' olanları göster
                        // Animasyon sınıfını ekliyoruz
                        row.classList.add('slide-in-fwd-center');
                    }
                }
            });
        }
        // Eğer 'date' filtresi seçilmişse, tarih sırasına göre sıralama (artan)
        else if (filterValue === 'date') {
            filteredRows.sort((rowA, rowB) => {
                const dateA = rowA.cells[2].innerText.trim(); // Tarih hücresindeki metni al
                const dateB = rowB.cells[2].innerText.trim(); // Tarih hücresindeki metni al

                // Tarih formatlarını 'dd-mm-yyyy' den 'yyyy-mm-dd' formatına dönüştürüp karşılaştıracağız
                const [dayA, monthA, yearA] = dateA.split('-').map(num => parseInt(num, 10));
                const [dayB, monthB, yearB] = dateB.split('-').map(num => parseInt(num, 10));

                // Date nesneleri oluşturuyoruz
                const dateAObj = new Date(yearA, monthA - 1, dayA); // monthA - 1 çünkü JS'de aylar 0'dan başlar
                const dateBObj = new Date(yearB, monthB - 1, dayB);

                // Tarihleri karşılaştırıyoruz (Artan sıralama)
                return dateAObj - dateBObj;
            });
            filteredRows.forEach(row => {
                row.style.display = ''; // Tüm satırları göster
                // Animasyon sınıfını ekliyoruz
                row.classList.add('slide-in-fwd-center');
            });
        }
        // Eğer 'date_desc' filtresi seçilmişse, tarih azalan sıralama
        else if (filterValue === 'date_desc') {
            filteredRows.sort((rowA, rowB) => {
                const dateA = rowA.cells[2].innerText.trim(); // Tarih hücresindeki metni al
                const dateB = rowB.cells[2].innerText.trim(); // Tarih hücresindeki metni al

                // Tarih formatlarını 'dd-mm-yyyy' den 'yyyy-mm-dd' formatına dönüştürüp karşılaştıracağız
                const [dayA, monthA, yearA] = dateA.split('-').map(num => parseInt(num, 10));
                const [dayB, monthB, yearB] = dateB.split('-').map(num => parseInt(num, 10));

                // Date nesneleri oluşturuyoruz
                const dateAObj = new Date(yearA, monthA - 1, dayA); // monthA - 1 çünkü JS'de aylar 0'dan başlar
                const dateBObj = new Date(yearB, monthB - 1, dayB);

                // Tarihleri karşılaştırıyoruz (Azalan sıralama)
                return dateBObj - dateAObj; // Azalan sıralama için tersten karşılaştırıyoruz
            });
            filteredRows.forEach(row => {
                row.style.display = ''; // Tüm satırları göster
                // Animasyon sınıfını ekliyoruz
                row.classList.add('slide-in-fwd-center');
            });
        }
        // Eğer herhangi bir filtre yoksa, tüm satırları tekrar göster
        else {
            filteredRows.forEach(row => {
                row.style.display = ''; // Tüm satırları göster
                // Animasyon sınıfını ekliyoruz
                row.classList.add('slide-in-fwd-center');
            });
        }
    });
});
