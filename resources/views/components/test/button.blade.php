<button id="test-button" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
    Hacer Clic
</button>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const testButton = document.getElementById("test-button");
    
    if (testButton) {
        testButton.addEventListener("click", function() {
            alert("¡Hola! El JavaScript funciona correctamente.");
        });
    }
});
</script>
