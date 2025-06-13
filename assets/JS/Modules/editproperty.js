document.getElementById("updateForm").addEventListener("submit", function(e) {
  e.preventDefault(); // Prevent form from reloading the page

  const form = e.target;
  const formData = new FormData(form);
  formData.append("update", "1"); // Add the 'update' flag like PHP expects

  fetch("update_property.php?id=123", {
    method: "POST",
    body: formData,
  })
  .then(response => response.json())
  .then(data => {
    const status = document.getElementById("status");
    if (data.success) {
      status.innerText = "Property updated successfully!";
      status.style.color = "green";
    } else {
      status.innerText = "Error: " + data.message;
      status.style.color = "red";
    }
  })
  .catch(error => {
    console.error("Request failed:", error);
    document.getElementById("status").innerText = "Something went wrong.";
  });
});
