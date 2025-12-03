CREATE TABLE
    Customers (
        customer_id INT PRIMARY KEY AUTO_INCREMENT,
        full_name VARCHAR(20) NOT NULL,
        email VARCHAR(50) NOT NULL,
        phone VARCHAR(20),
        registration_date DATE
    );

CREATE TABLE
    Advisors (
        advisor_id INT PRIMARY KEY AUTO_INCREMENT,
        full_name VARCHAR(20) NOT NULL,
        email VARCHAR(50) NOT NULL
    );

CREATE TABLE
    Accounts (
        account_id INT PRIMARY KEY AUTO_INCREMENT,
        account_number VARCHAR(20) NOT NULL,
        balance DECIMAL(15, 2) DEFAULT 0,
        account_type ENUM ('Checking', 'Savings', 'Business'),
        customer_id INT,
        advisor_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (customer_id) REFERENCES Customers (Customers_id),
        FOREIGN KEY (advisor_id) REFERENCES Advisors (advisor_id)
    );