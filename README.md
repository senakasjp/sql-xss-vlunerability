# Lab: Fixing SQL Injection and XSS Vulnerabilities in a PHP-MySQL Application

## 🎯 Objective

This lab demonstrates how to identify and fix **SQL Injection** and **Cross-Site Scripting (XSS)** vulnerabilities in a PHP web application.

---

## 🧰 Requirements

- Ubuntu Linux
- PHP vulnerable app from GitHub  
  👉 [https://github.com/senakasjp/sql-xss-vlunerability](https://github.com/senakasjp/sql-xss-vlunerability)
- Web browser
- Text/code editor

---

## 🛠️ 1. Setup

1. Download and run the installation script:
   ```bash
   wget https://github.com/senakasjp/sql-xss-vlunerability/raw/main/install.sh
   chmod +x install.sh
   ./install.sh
   ```

2. Open your browser and go to:
   ```
   http://localhost
   ```

---

## 🧨 2. Demonstrating SQL Injection

- **Username:** `' OR 1=1#`
- **Password:** *(any value)*

🧪 Expected Outcome:
> You should see all user accounts displayed — this confirms a successful SQL injection.

---

## 🔥 3. Demonstrating XSS

- **Username:**  
  ```html
  <script>alert('XSS  Attack')</script>
  ```
- **Password:** *(any value)*

🧪 Expected Outcome:
> A popup alert should appear — confirming reflected XSS.

---

## 🔧 4. Locate and Fix the Vulnerabilities

- Open the file:
  ```bash
  sudo nano /var/www/html/index.php
  ```

- **Replace this vulnerable query:**
  ```php
  $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
  ```

- **With a prepared statement:**
  ```php
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();
  ```

- **Escape echoed user input to prevent XSS:**
  ```php
  $username = htmlspecialchars($username);
  ```

---

## ✅ 5. Test Again

- Try the same SQL Injection and XSS payloads again.
- You should **no longer** be able to exploit them.

---

## 📸 Deliverables

- ✅ Screenshots of SQL Injection **before and after the fix**
- ✅ Screenshots of XSS **before and after the fix**
- ✅ A short write-up explaining each vulnerability and how you fixed it

---

Happy Ethical hacking 
