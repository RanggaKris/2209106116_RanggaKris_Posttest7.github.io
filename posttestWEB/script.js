//tombol toggle dan elemen body
const themeToggle = document.getElementById("aa-button");
const body = document.body;

// Cek status tema dari localStorage 
const currentTheme = localStorage.getItem("theme");

// tema awal
if (currentTheme) {
    body.classList.add(currentTheme);
}

// event listener untuk mengganti tema 
themeToggle.addEventListener("click", () => {
    if (body.classList.contains("dark-mode")) {
        body.classList.remove("dark-mode");
        localStorage.setItem("theme", "light-mode");

        // Manipulasi DOM pada dark mode
        body.style.fontSize = "16px";
        body.style.margin = "20px";

        // Menampilkan popup box
        alert("Anda mengganti ke light mode.");

    } else {
        body.classList.add("dark-mode");
        localStorage.setItem("theme", "dark-mode");

        // Manipulasi DOM pada dark mode
        body.style.fontSize = "18px";
        body.style.margin = "10px";
        
        // Menampilkan popup box
        alert("Anda mengganti ke dark mode.");
    }
});
