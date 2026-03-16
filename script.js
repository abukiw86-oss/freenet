    document.getElementById("signupForm").addEventListener("submit", function(event) {
      event;

      let valid = true;

      document.querySelectorAll(".error-message").forEach(el => el.innerText = "");
      document.querySelectorAll("input").forEach(el => el.classList.remove("error"));

      const email = document.getElementById("email");
      if (email.value === "" || !/^\S+@\S+\.\S+$/.test(email.value)) {
        document.getElementById("emailError").innerText = "Please enter a valid email.";
        email.classList.add("error");
        valid = false;
      }

      const phone = document.getElementById("phone");
      if (phone.value === "" || !/^[0-9]{9,15}$/.test(phone.value)) {
        document.getElementById("phoneError").innerText = "Enter a valid phone number (9-15 digits).";
        phone.classList.add("error");
        valid = false;
      }
      
      const password = document.getElementById("password");
      if (password.value.length < 6) {
        document.getElementById("passwordError").innerText = "Password must be at least 6 characters.";
        password.classList.add("error");
        valid = false;
      }
    });