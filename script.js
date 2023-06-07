var button_prev = document.getElementById("prev");
var button_next = document.getElementById("next");

// Tambahkan event listener untuk 'keydown' pada seluruh dokumen
document.addEventListener("keydown", function(event) {
  // Periksa kode tombol yang ditekan
  switch(event.keyCode) {
    case 37:
      // Tombol panah kiri
      button_prev.click();
      break;
    case 38:
      // Tombol panah atas
      button_prev.click();
      break;
    case 39:
      // Tombol panah kanan
      button_next.click();
      break;
    case 40:
      // Tombol panah bawah
      button_next.click();
      break;
  }
});