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

CREATE TABLE
    Transactions (
        transaction_id INT PRIMARY KEY AUTO_INCREMENT,
        amount DECIMAL(15, 2) NOT NULL,
        transaction_type ENUM ('debit', 'credit') NOT NULL,
        transaction_date DATE,
        account_id INT,
        FOREIGN KEY (account_id) REFERENCES Accounts (account_id)
    );

INSERT INTO
    Customers (full_name, email, phone, registration_date)
VALUES
    (
        'Mohamed Sabir',
        'mohamed@example.com',
        '0612345678',
        '2025-12-01'
    ),
    (
        'Yassine Ben',
        'yassine@example.com',
        '0623456789',
        '2025-12-02'
    ),
    (
        'Omar Khalid',
        'omar@example.com',
        '0634567890',
        '2025-12-03'
    ),
    (
        'Fatima Zahra',
        'fatima@example.com',
        '0645678901',
        '2025-12-04'
    ),
    (
        'Ahmed Rami',
        'ahmed@example.com',
        '0656789012',
        '2025-12-05'
    ),
    (
        'Sara Laila',
        'sara@example.com',
        '0667890123',
        '2025-12-06'
    ),
    (
        'Hassan Idris',
        'hassan@example.com',
        '0678901234',
        '2025-12-07'
    ),
    (
        'Meryem Amal',
        'meryem@example.com',
        '0689012345',
        '2025-12-08'
    ),
    (
        'Youssef Anas',
        'youssef@example.com',
        '0690123456',
        '2025-12-09'
    ),
    (
        'Khadija Salma',
        'khadija@example.com',
        '0601234567',
        '2025-12-10'
    ),
    (
        'Ilyas Karim',
        'ilyas@example.com',
        '0612345670',
        '2025-12-11'
    ),
    (
        'Nour Amina',
        'nour@example.com',
        '0623456701',
        '2025-12-12'
    ),
    (
        'Said Rayan',
        'said@example.com',
        '0634567012',
        '2025-12-13'
    ),
    (
        'Leila Hanae',
        'leila@example.com',
        '0645670123',
        '2025-12-14'
    ),
    (
        'Othman Imane',
        'othman@example.com',
        '0656701234',
        '2025-12-15'
    ),
    (
        'Rachid Samir',
        'rachid@example.com',
        '0667012345',
        '2025-12-16'
    ),
    (
        'Hind Malak',
        'hind@example.com',
        '0670123456',
        '2025-12-17'
    ),
    (
        'Bilal Nabil',
        'bilal@example.com',
        '0681234567',
        '2025-12-18'
    ),
    (
        'Yasmine Loubna',
        'yasmine@example.com',
        '0692345678',
        '2025-12-19'
    ),
    (
        'Anas Mehdi',
        'anas@example.com',
        '0603456789',
        '2025-12-20'
    ),
    (
        'Imane Salim',
        'imane@example.com',
        '0614567890',
        '2025-12-21'
    ),
    (
        'Omar Idriss',
        'omar.idriss@example.com',
        '0625678901',
        '2025-12-22'
    ),
    (
        'Sara Hana',
        'sara.hana@example.com',
        '0636789012',
        '2025-12-23'
    ),
    (
        'Rachid Omar',
        'rachid.omar@example.com',
        '0647890123',
        '2025-12-24'
    ),
    (
        'Laila Youssef',
        'laila.youssef@example.com',
        '0658901234',
        '2025-12-25'
    ),
    (
        'Khalid Mehdi',
        'khalid.mehdi@example.com',
        '0669012345',
        '2025-12-26'
    ),
    (
        'Malak Samir',
        'malak.samir@example.com',
        '0670123456',
        '2025-12-27'
    ),
    (
        'Nabil Idris',
        'nabil.idris@example.com',
        '0681234567',
        '2025-12-28'
    ),
    (
        'Amal Salma',
        'amal.salma@example.com',
        '0692345678',
        '2025-12-29'
    ),
    (
        'Youssef Karim',
        'youssef.karim@example.com',
        '0603456789',
        '2025-12-30'
    ),
    (
        'Hanae Imane',
        'hanae.imane@example.com',
        '0614567890',
        '2025-12-31'
    ),
    (
        'Rayan Anas',
        'rayan.anas@example.com',
        '0625678901',
        '2026-01-01'
    ),
    (
        'Salim Bilal',
        'salim.bilal@example.com',
        '0636789012',
        '2026-01-02'
    ),
    (
        'Loubna Hind',
        'loubna.hind@example.com',
        '0647890123',
        '2026-01-03'
    ),
    (
        'Idris Omar',
        'idris.omar@example.com',
        '0658901234',
        '2026-01-04'
    ),
    (
        'Amina Yasmine',
        'amina.yasmine@example.com',
        '0669012345',
        '2026-01-05'
    ),
    (
        'Karim Nabil',
        'karim.nabil@example.com',
        '0670123456',
        '2026-01-06'
    ),
    (
        'Salma Leila',
        'salma.leila@example.com',
        '0681234567',
        '2026-01-07'
    ),
    (
        'Mehdi Khalid',
        'mehdi.khalid@example.com',
        '0692345678',
        '2026-01-08'
    ),
    (
        'Samir Rachid',
        'samir.rachid@example.com',
        '0603456789',
        '2026-01-09'
    ),
    (
        'Imane Hanae',
        'imane.hanae@example.com',
        '0614567890',
        '2026-01-10'
    ),
    (
        'Omar Bilal',
        'omar.bilal@example.com',
        '0625678901',
        '2026-01-11'
    ),
    (
        'Hanae Malak',
        'hanae.malak@example.com',
        '0636789012',
        '2026-01-12'
    ),
    (
        'Yassine Idris',
        'yassine.idris@example.com',
        '0647890123',
        '2026-01-13'
    ),
    (
        'Fatima Laila',
        'fatima.laila@example.com',
        '0658901234',
        '2026-01-14'
    ),
    (
        'Rayan Anas',
        'rayan.anas2@example.com',
        '0669012345',
        '2026-01-15'
    ),
    (
        'Sara Hana',
        'sara.hana2@example.com',
        '0670123456',
        '2026-01-16'
    ),
    (
        'Karim Youssef',
        'karim.youssef@example.com',
        '0681234567',
        '2026-01-17'
    ),
    (
        'Leila Salma',
        'leila.salma@example.com',
        '0692345678',
        '2026-01-18'
    ),
    (
        'Nabil Mehdi',
        'nabil.mehdi@example.com',
        '0603456789',
        '2026-01-19'
    ),
    (
        'Malak Amina',
        'malak.amina@example.com',
        '0614567890',
        '2026-01-20'
    ),
    (
        'Idris Omar',
        'idris.omar2@example.com',
        '0625678901',
        '2026-01-21'
    );

(
    'Mohamed Sabir',
    'mohamed@example.com',
    '0612345678',
    '2025-12-01'
),
(
    'Yassine Ben',
    'yassine@example.com',
    '0623456789',
    '2025-12-02'
),
(
    'Omar Khalid',
    'omar@example.com',
    '0634567890',
    '2025-12-03'
),
(
    'Fatima Zahra',
    'fatima@example.com',
    '0645678901',
    '2025-12-04'
),
(
    'Ahmed Rami',
    'ahmed@example.com',
    '0656789012',
    '2025-12-05'
),
(
    'Sara Laila',
    'sara@example.com',
    '0667890123',
    '2025-12-06'
),
(
    'Hassan Idris',
    'hassan@example.com',
    '0678901234',
    '2025-12-07'
),
(
    'Meryem Amal',
    'meryem@example.com',
    '0689012345',
    '2025-12-08'
),
(
    'Youssef Anas',
    'youssef@example.com',
    '0690123456',
    '2025-12-09'
),
(
    'Khadija Salma',
    'khadija@example.com',
    '0601234567',
    '2025-12-10'
),
(
    'Ilyas Karim',
    'ilyas@example.com',
    '0612345670',
    '2025-12-11'
),
(
    'Nour Amina',
    'nour@example.com',
    '0623456701',
    '2025-12-12'
),
(
    'Said Rayan',
    'said@example.com',
    '0634567012',
    '2025-12-13'
),
(
    'Leila Hanae',
    'leila@example.com',
    '0645670123',
    '2025-12-14'
),
(
    'Othman Imane',
    'othman@example.com',
    '0656701234',
    '2025-12-15'
),
(
    'Rachid Samir',
    'rachid@example.com',
    '0667012345',
    '2025-12-16'
),
(
    'Hind Malak',
    'hind@example.com',
    '0670123456',
    '2025-12-17'
),
(
    'Bilal Nabil',
    'bilal@example.com',
    '0681234567',
    '2025-12-18'
),
(
    'Yasmine Loubna',
    'yasmine@example.com',
    '0692345678',
    '2025-12-19'
),
(
    'Anas Mehdi',
    'anas@example.com',
    '0603456789',
    '2025-12-20'
),
(
    'Imane Salim',
    'imane@example.com',
    '0614567890',
    '2025-12-21'
),
(
    'Omar Idriss',
    'omar.idriss@example.com',
    '0625678901',
    '2025-12-22'
),
(
    'Sara Hana',
    'sara.hana@example.com',
    '0636789012',
    '2025-12-23'
),
(
    'Rachid Omar',
    'rachid.omar@example.com',
    '0647890123',
    '2025-12-24'
),
(
    'Laila Youssef',
    'laila.youssef@example.com',
    '0658901234',
    '2025-12-25'
),
(
    'Khalid Mehdi',
    'khalid.mehdi@example.com',
    '0669012345',
    '2025-12-26'
),
(
    'Malak Samir',
    'malak.samir@example.com',
    '0670123456',
    '2025-12-27'
),
(
    'Nabil Idris',
    'nabil.idris@example.com',
    '0681234567',
    '2025-12-28'
),
(
    'Amal Salma',
    'amal.salma@example.com',
    '0692345678',
    '2025-12-29'
),
(
    'Youssef Karim',
    'youssef.karim@example.com',
    '0603456789',
    '2025-12-30'
),
(
    'Hanae Imane',
    'hanae.imane@example.com',
    '0614567890',
    '2025-12-31'
),
(
    'Rayan Anas',
    'rayan.anas@example.com',
    '0625678901',
    '2026-01-01'
),
(
    'Salim Bilal',
    'salim.bilal@example.com',
    '0636789012',
    '2026-01-02'
),
(
    'Loubna Hind',
    'loubna.hind@example.com',
    '0647890123',
    '2026-01-03'
),
(
    'Idris Omar',
    'idris.omar@example.com',
    '0658901234',
    '2026-01-04'
),
(
    'Amina Yasmine',
    'amina.yasmine@example.com',
    '0669012345',
    '2026-01-05'
),
(
    'Karim Nabil',
    'karim.nabil@example.com',
    '0670123456',
    '2026-01-06'
),
(
    'Salma Leila',
    'salma.leila@example.com',
    '0681234567',
    '2026-01-07'
),
(
    'Mehdi Khalid',
    'mehdi.khalid@example.com',
    '0692345678',
    '2026-01-08'
),
(
    'Samir Rachid',
    'samir.rachid@example.com',
    '0603456789',
    '2026-01-09'
),
(
    'Imane Hanae',
    'imane.hanae@example.com',
    '0614567890',
    '2026-01-10'
),
(
    'Omar Bilal',
    'omar.bilal@example.com',
    '0625678901',
    '2026-01-11'
),
(
    'Hanae Malak',
    'hanae.malak@example.com',
    '0636789012',
    '2026-01-12'
),
(
    'Yassine Idris',
    'yassine.idris@example.com',
    '0647890123',
    '2026-01-13'
),
(
    'Fatima Laila',
    'fatima.laila@example.com',
    '0658901234',
    '2026-01-14'
),
(
    'Rayan Anas',
    'rayan.anas2@example.com',
    '0669012345',
    '2026-01-15'
),
(
    'Sara Hana',
    'sara.hana2@example.com',
    '0670123456',
    '2026-01-16'
),
(
    'Karim Youssef',
    'karim.youssef@example.com',
    '0681234567',
    '2026-01-17'
),
(
    'Leila Salma',
    'leila.salma@example.com',
    '0692345678',
    '2026-01-18'
),
(
    'Nabil Mehdi',
    'nabil.mehdi@example.com',
    '0603456789',
    '2026-01-19'
),
(
    'Malak Amina',
    'malak.amina@example.com',
    '0614567890',
    '2026-01-20'
),
(
    'Idris Omar',
    'idris.omar2@example.com',
    '0625678901',
    '2026-01-21'
);

INSERT INTO
    Advisors (full_name, email)
VALUES
    ('Mohamed Sabir', 'mohamed.sabir@example.com'),
    ('Yassine Ben', 'yassine.ben@example.com'),
    ('Omar Khalid', 'omar.khalid@example.com'),
    ('Fatima Zahra', 'fatima.zahra@example.com'),
    ('Ahmed Rami', 'ahmed.rami@example.com'),
    ('Sara Laila', 'sara.laila@example.com'),
    ('Hassan Idris', 'hassan.idris@example.com'),
    ('Meryem Amal', 'meryem.amal@example.com'),
    ('Youssef Anas', 'youssef.anas@example.com'),
    ('Khadija Salma', 'khadija.salma@example.com'),
    ('Ilyas Karim', 'ilyas.karim@example.com'),
    ('Nour Amina', 'nour.amina@example.com'),
    ('Said Rayan', 'said.rayan@example.com'),
    ('Leila Hanae', 'leila.hanae@example.com'),
    ('Othman Imane', 'othman.imane@example.com'),
    ('Rachid Samir', 'rachid.samir@example.com'),
    ('Hind Malak', 'hind.malak@example.com'),
    ('Bilal Nabil', 'bilal.nabil@example.com'),
    ('Yasmine Loubna', 'yasmine.loubna@example.com'),
    ('Anas Mehdi', 'anas.mehdi@example.com'),
    ('Imane Salim', 'imane.salim@example.com'),
    ('Omar Idriss', 'omar.idriss@example.com'),
    ('Sara Hana', 'sara.hana@example.com'),
    ('Rachid Omar', 'rachid.omar@example.com'),
    ('Laila Youssef', 'laila.youssef@example.com'),
    ('Khalid Mehdi', 'khalid.mehdi@example.com'),
    ('Malak Samir', 'malak.samir@example.com'),
    ('Nabil Idris', 'nabil.idris@example.com'),
    ('Amal Salma', 'amal.salma@example.com'),
    ('Youssef Karim', 'youssef.karim@example.com'),
    ('Hanae Imane', 'hanae.imane@example.com'),
    ('Rayan Anas', 'rayan.anas@example.com'),
    ('Salim Bilal', 'salim.bilal@example.com'),
    ('Loubna Hind', 'loubna.hind@example.com'),
    ('Idris Omar', 'idris.omar@example.com'),
    ('Amina Yasmine', 'amina.yasmine@example.com'),
    ('Karim Nabil', 'karim.nabil@example.com'),
    ('Salma Leila', 'salma.leila@example.com'),
    ('Mehdi Khalid', 'mehdi.khalid@example.com'),
    ('Samir Rachid', 'samir.rachid@example.com'),
    ('Imane Hanae', 'imane.hanae2@example.com'),
    ('Omar Bilal', 'omar.bilal@example.com'),
    ('Hanae Malak', 'hanae.malak2@example.com'),
    ('Yassine Idris', 'yassine.idris@example.com'),
    ('Fatima Laila', 'fatima.laila2@example.com'),
    ('Rayan Anas', 'rayan.anas2@example.com'),
    ('Sara Hana', 'sara.hana2@example.com'),
    ('Karim Youssef', 'karim.youssef@example.com'),
    ('Leila Salma', 'leila.salma2@example.com'),
    ('Nabil Mehdi', 'nabil.mehdi2@example.com'),
    ('Malak Amina', 'malak.amina2@example.com'),
    ('Idris Omar', 'idris.omar2@example.com');