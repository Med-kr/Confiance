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