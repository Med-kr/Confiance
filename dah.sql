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

INSERT INTO
    Accounts (
        account_number,
        balance,
        account_type,
        customer_id,
        advisor_id
    )
VALUES
    ('CHK1001', 15000, 'Checking', 1, 1),
    ('SAV2001', 8000, 'Savings', 1, 1),
    ('BUS3001', 50000, 'Business', 2, 2),
    ('SAV2002', 200, 'Savings', 3, 2),
    ('CHK1002', 1200, 'Checking', 2, 1),
    ('SAV2003', 3400, 'Savings', 3, 2),
    ('BUS3002', 78000, 'Business', 4, 3),
    ('CHK1003', 560, 'Checking', 5, 1),
    ('SAV2004', 9100, 'Savings', 6, 2),
    ('BUS3003', 150000, 'Business', 7, 3),
    ('CHK1004', 2300, 'Checking', 8, 1),
    ('SAV2005', 4500, 'Savings', 9, 2),
    ('BUS3004', 62000, 'Business', 10, 3),
    ('CHK1005', 780, 'Checking', 11, 1),
    ('SAV2006', 9200, 'Savings', 12, 2),
    ('BUS3005', 130000, 'Business', 13, 3),
    ('CHK1006', 4500, 'Checking', 14, 1),
    ('SAV2007', 3100, 'Savings', 15, 2),
    ('BUS3006', 99000, 'Business', 16, 3),
    ('CHK1007', 12000, 'Checking', 17, 1),
    ('SAV2008', 6700, 'Savings', 18, 2),
    ('BUS3007', 54000, 'Business', 19, 3),
    ('CHK1008', 300, 'Checking', 20, 1),
    ('SAV2009', 15000, 'Savings', 21, 2),
    ('BUS3008', 87000, 'Business', 22, 3),
    ('CHK1009', 4500, 'Checking', 23, 1),
    ('SAV2010', 3200, 'Savings', 24, 2),
    ('BUS3009', 99000, 'Business', 25, 3),
    ('CHK1010', 780, 'Checking', 26, 1),
    ('SAV2011', 11000, 'Savings', 27, 2),
    ('BUS3010', 75000, 'Business', 28, 3),
    ('CHK1011', 5600, 'Checking', 29, 1),
    ('SAV2012', 4500, 'Savings', 30, 2),
    ('BUS3011', 88000, 'Business', 31, 3),
    ('CHK1012', 2300, 'Checking', 32, 1),
    ('SAV2013', 6700, 'Savings', 33, 2),
    ('BUS3012', 54000, 'Business', 34, 3),
    ('CHK1013', 1200, 'Checking', 35, 1),
    ('SAV2014', 9100, 'Savings', 36, 2),
    ('BUS3013', 150000, 'Business', 37, 3),
    ('CHK1014', 300, 'Checking', 38, 1),
    ('SAV2015', 4500, 'Savings', 39, 2),
    ('BUS3014', 62000, 'Business', 40, 3),
    ('CHK1015', 7800, 'Checking', 41, 1),
    ('SAV2016', 9200, 'Savings', 42, 2),
    ('BUS3015', 130000, 'Business', 43, 3),
    ('CHK1016', 4500, 'Checking', 44, 1),
    ('SAV2017', 3100, 'Savings', 45, 2),
    ('BUS3016', 99000, 'Business', 46, 3),
    ('CHK1017', 12000, 'Checking', 47, 1),
    ('SAV2018', 6700, 'Savings', 48, 2),
    ('BUS3017', 54000, 'Business', 49, 3),
    ('CHK1018', 300, 'Checking', 50, 1),
    ('SAV2019', 15000, 'Savings', 51, 2),
    ('BUS3018', 87000, 'Business', 52, 3),
    ('CHK1019', 4500, 'Checking', 53, 1),
    ('SAV2020', 3200, 'Savings', 54, 2),
    ('BUS3019', 99000, 'Business', 55, 3),
    ('CHK1020', 780, 'Checking', 56, 1),
    ('SAV2021', 11000, 'Savings', 57, 2),
    ('BUS3020', 75000, 'Business', 58, 3),
    ('CHK1021', 5600, 'Checking', 59, 1),
    ('SAV2022', 4500, 'Savings', 60, 2),
    ('BUS3021', 88000, 'Business', 61, 3),
    ('CHK1022', 2300, 'Checking', 62, 1),
    ('SAV2023', 6700, 'Savings', 63, 2),
    ('BUS3022', 54000, 'Business', 64, 3),
    ('CHK1023', 1200, 'Checking', 65, 1),
    ('SAV2024', 9100, 'Savings', 66, 2),
    ('BUS3023', 150000, 'Business', 67, 3),
    ('CHK1024', 300, 'Checking', 68, 1),
    ('SAV2025', 4500, 'Savings', 69, 2),
    ('BUS3024', 62000, 'Business', 70, 3),
    ('CHK1025', 7800, 'Checking', 71, 1),
    ('SAV2026', 9200, 'Savings', 72, 2),
    ('BUS3025', 130000, 'Business', 73, 3),
    ('CHK1026', 4500, 'Checking', 74, 1),
    ('SAV2027', 3100, 'Savings', 75, 2),
    ('BUS3026', 99000, 'Business', 76, 3),
    ('CHK1027', 12000, 'Checking', 77, 1),
    ('SAV2028', 6700, 'Savings', 78, 2),
    ('BUS3027', 54000, 'Business', 79, 3),
    ('CHK1028', 300, 'Checking', 80, 1),
    ('SAV2029', 15000, 'Savings', 81, 2),
    ('BUS3028', 87000, 'Business', 82, 3),
    ('CHK1029', 4500, 'Checking', 83, 1),
    ('SAV2030', 3200, 'Savings', 84, 2),
    ('BUS3029', 99000, 'Business', 85, 3),
    ('CHK1030', 780, 'Checking', 86, 1),
    ('SAV2031', 11000, 'Savings', 87, 2),
    ('BUS3030', 75000, 'Business', 88, 3),
    ('CHK1031', 5600, 'Checking', 89, 1),
    ('SAV2032', 4500, 'Savings', 90, 2),
    ('BUS3031', 88000, 'Business', 91, 3),
    ('CHK1032', 2300, 'Checking', 92, 1),
    ('SAV2033', 6700, 'Savings', 93, 2),
    ('BUS3032', 54000, 'Business', 94, 3),
    ('CHK1033', 1200, 'Checking', 95, 1),
    ('SAV2034', 9100, 'Savings', 96, 2),
    ('BUS3033', 150000, 'Business', 97, 3),
    ('CHK1034', 300, 'Checking', 98, 1),
    ('SAV2035', 4500, 'Savings', 99, 2),
    ('BUS3034', 62000, 'Business', 100, 3);

INSERT INTO
    Transactions (
        amount,
        transaction_type,
        transaction_date,
        account_id
    )
VALUES
    (500, 'debit', '2025-12-01', 1),
    (1000, 'credit', '2025-12-02', 1),
    (300, 'debit', '2025-12-02', 2),
    (1500, 'credit', '2025-12-03', 3),
    (200, 'debit', '2025-12-03', 4),
    (750, 'credit', '2025-12-04', 5),
    (400, 'debit', '2025-12-04', 6),
    (1200, 'credit', '2025-12-05', 7),
    (600, 'debit', '2025-12-05', 8),
    (900, 'credit', '2025-12-06', 9),
    (250, 'debit', '2025-12-06', 10),
    (1800, 'credit', '2025-12-07', 11),
    (350, 'debit', '2025-12-07', 12),
    (1000, 'credit', '2025-12-08', 13),
    (500, 'debit', '2025-12-08', 14),
    (750, 'credit', '2025-12-09', 15),
    (300, 'debit', '2025-12-09', 16),
    (1200, 'credit', '2025-12-10', 17),
    (600, 'debit', '2025-12-10', 18),
    (950, 'credit', '2025-12-11', 19),
    (400, 'debit', '2025-12-11', 20),
    (1100, 'credit', '2025-12-12', 21),
    (250, 'debit', '2025-12-12', 22),
    (1600, 'credit', '2025-12-13', 23),
    (350, 'debit', '2025-12-13', 24),
    (700, 'credit', '2025-12-14', 25),
    (450, 'debit', '2025-12-14', 26),
    (1300, 'credit', '2025-12-15', 27),
    (500, 'debit', '2025-12-15', 28),
    (800, 'credit', '2025-12-16', 29),
    (300, 'debit', '2025-12-16', 30),
    (1000, 'credit', '2025-12-17', 31),
    (200, 'debit', '2025-12-17', 32),
    (1500, 'credit', '2025-12-18', 33),
    (400, 'debit', '2025-12-18', 34),
    (600, 'credit', '2025-12-19', 35),
    (250, 'debit', '2025-12-19', 36),
    (900, 'credit', '2025-12-20', 37),
    (500, 'debit', '2025-12-20', 38),
    (1100, 'credit', '2025-12-21', 39),
    (300, 'debit', '2025-12-21', 40),
    (700, 'credit', '2025-12-22', 41),
    (450, 'debit', '2025-12-22', 42),
    (1200, 'credit', '2025-12-23', 43),
    (600, 'debit', '2025-12-23', 44),
    (1000, 'credit', '2025-12-24', 45),
    (250, 'debit', '2025-12-24', 46),
    (1300, 'credit', '2025-12-25', 47),
    (350, 'debit', '2025-12-25', 48),
    (800, 'credit', '2025-12-26', 49),
    (400, 'debit', '2025-12-26', 50),
    (900, 'credit', '2025-12-27', 51),
    (300, 'debit', '2025-12-27', 52),
    (1000, 'credit', '2025-12-28', 53),
    (500, 'debit', '2025-12-28', 54),
    (1500, 'credit', '2025-12-29', 55),
    (200, 'debit', '2025-12-29', 56),
    (700, 'credit', '2025-12-30', 57),
    (350, 'debit', '2025-12-30', 58),
    (1200, 'credit', '2025-12-31', 59),
    (400, 'debit', '2025-12-31', 60),
    (600, 'credit', '2026-01-01', 61),
    (250, 'debit', '2026-01-01', 62),
    (900, 'credit', '2026-01-02', 63),
    (500, 'debit', '2026-01-02', 64),
    (1100, 'credit', '2026-01-03', 65),
    (300, 'debit', '2026-01-03', 66),
    (700, 'credit', '2026-01-04', 67),
    (450, 'debit', '2026-01-04', 68),
    (1200, 'credit', '2026-01-05', 69),
    (600, 'debit', '2026-01-05', 70),
    (1000, 'credit', '2026-01-06', 71),
    (250, 'debit', '2026-01-06', 72),
    (1300, 'credit', '2026-01-07', 73),
    (350, 'debit', '2026-01-07', 74),
    (800, 'credit', '2026-01-08', 75),
    (400, 'debit', '2026-01-08', 76),
    (900, 'credit', '2026-01-09', 77),
    (300, 'debit', '2026-01-09', 78),
    (1000, 'credit', '2026-01-10', 79),
    (500, 'debit', '2026-01-10', 80),
    (1500, 'credit', '2026-01-11', 81),
    (200, 'debit', '2026-01-11', 82),
    (700, 'credit', '2026-01-12', 83),
    (350, 'debit', '2026-01-12', 84),
    (1200, 'credit', '2026-01-13', 85),
    (400, 'debit', '2026-01-13', 86),
    (600, 'credit', '2026-01-14', 87),
    (250, 'debit', '2026-01-14', 88),
    (900, 'credit', '2026-01-15', 89),
    (500, 'debit', '2026-01-15', 90),
    (1100, 'credit', '2026-01-16', 91),
    (300, 'debit', '2026-01-16', 92),
    (700, 'credit', '2026-01-17', 93),
    (450, 'debit', '2026-01-17', 94),
    (1200, 'credit', '2026-01-18', 95),
    (600, 'debit', '2026-01-18', 96),
    (1000, 'credit', '2026-01-19', 97),
    (250, 'debit', '2026-01-19', 98),
    (1300, 'credit', '2026-01-20', 99),
    (350, 'debit', '2026-01-20', 100);

INSERT INTO
    Accounts (
        account_number,
        balance,
        account_type,
        customer_id,
        advisor_id
    )
VALUES
    ('CHK1001', 15000, 'Checking', 1, 1),
    ('SAV2001', 8000, 'Savings', 1, 1),
    ('BUS3001', 50000, 'Business', 2, 2),
    ('SAV2002', 200, 'Savings', 3, 2),
    ('CHK1002', 1200, 'Checking', 2, 1),
    ('SAV2003', 3400, 'Savings', 3, 2),
    ('BUS3002', 78000, 'Business', 4, 3),
    ('CHK1003', 560, 'Checking', 5, 1),
    ('SAV2004', 9100, 'Savings', 6, 2),
    ('BUS3003', 150000, 'Business', 7, 3),
    ('CHK1004', 2300, 'Checking', 8, 1),
    ('SAV2005', 4500, 'Savings', 9, 2),
    ('BUS3004', 62000, 'Business', 10, 3),
    ('CHK1005', 780, 'Checking', 11, 1),
    ('SAV2006', 9200, 'Savings', 12, 2),
    ('BUS3005', 130000, 'Business', 13, 3),
    ('CHK1006', 4500, 'Checking', 14, 1),
    ('SAV2007', 3100, 'Savings', 15, 2),
    ('BUS3006', 99000, 'Business', 16, 3),
    ('CHK1007', 12000, 'Checking', 17, 1),
    ('SAV2008', 6700, 'Savings', 18, 2),
    ('BUS3007', 54000, 'Business', 19, 3),
    ('CHK1008', 300, 'Checking', 20, 1),
    ('SAV2009', 15000, 'Savings', 21, 2),
    ('BUS3008', 87000, 'Business', 22, 3),
    ('CHK1009', 4500, 'Checking', 23, 1),
    ('SAV2010', 3200, 'Savings', 24, 2),
    ('BUS3009', 99000, 'Business', 25, 3),
    ('CHK1010', 780, 'Checking', 26, 1),
    ('SAV2011', 11000, 'Savings', 27, 2),
    ('BUS3010', 75000, 'Business', 28, 3),
    ('CHK1011', 5600, 'Checking', 29, 1),
    ('SAV2012', 4500, 'Savings', 30, 2),
    ('BUS3011', 88000, 'Business', 31, 3),
    ('CHK1012', 2300, 'Checking', 32, 1),
    ('SAV2013', 6700, 'Savings', 33, 2),
    ('BUS3012', 54000, 'Business', 34, 3),
    ('CHK1013', 1200, 'Checking', 35, 1),
    ('SAV2014', 9100, 'Savings', 36, 2),
    ('BUS3013', 150000, 'Business', 37, 3),
    ('CHK1014', 300, 'Checking', 38, 1),
    ('SAV2015', 4500, 'Savings', 39, 2),
    ('BUS3014', 62000, 'Business', 40, 3),
    ('CHK1015', 7800, 'Checking', 41, 1),
    ('SAV2016', 9200, 'Savings', 42, 2),
    ('BUS3015', 130000, 'Business', 43, 3),
    ('CHK1016', 4500, 'Checking', 44, 1),
    ('SAV2017', 3100, 'Savings', 45, 2),
    ('BUS3016', 99000, 'Business', 46, 3),
    ('CHK1017', 12000, 'Checking', 47, 1),
    ('SAV2018', 6700, 'Savings', 48, 2),
    ('BUS3017', 54000, 'Business', 49, 3),
    ('CHK1018', 300, 'Checking', 50, 1),
    ('SAV2019', 15000, 'Savings', 51, 2),
    ('BUS3018', 87000, 'Business', 52, 3),
    ('CHK1019', 4500, 'Checking', 53, 1),
    ('SAV2020', 3200, 'Savings', 54, 2),
    ('BUS3019', 99000, 'Business', 55, 3),
    ('CHK1020', 780, 'Checking', 56, 1),
    ('SAV2021', 11000, 'Savings', 57, 2),
    ('BUS3020', 75000, 'Business', 58, 3),
    ('CHK1021', 5600, 'Checking', 59, 1),
    ('SAV2022', 4500, 'Savings', 60, 2),
    ('BUS3021', 88000, 'Business', 61, 3),
    ('CHK1022', 2300, 'Checking', 62, 1),
    ('SAV2023', 6700, 'Savings', 63, 2),
    ('BUS3022', 54000, 'Business', 64, 3),
    ('CHK1023', 1200, 'Checking', 65, 1),
    ('SAV2024', 9100, 'Savings', 66, 2),
    ('BUS3023', 150000, 'Business', 67, 3),
    ('CHK1024', 300, 'Checking', 68, 1),
    ('SAV2025', 4500, 'Savings', 69, 2),
    ('BUS3024', 62000, 'Business', 70, 3),
    ('CHK1025', 7800, 'Checking', 71, 1),
    ('SAV2026', 9200, 'Savings', 72, 2),
    ('BUS3025', 130000, 'Business', 73, 3),
    ('CHK1026', 4500, 'Checking', 74, 1),
    ('SAV2027', 3100, 'Savings', 75, 2),
    ('BUS3026', 99000, 'Business', 76, 3),
    ('CHK1027', 12000, 'Checking', 77, 1),
    ('SAV2028', 6700, 'Savings', 78, 2),
    ('BUS3027', 54000, 'Business', 79, 3),
    ('CHK1028', 300, 'Checking', 80, 1),
    ('SAV2029', 15000, 'Savings', 81, 2),
    ('BUS3028', 87000, 'Business', 82, 3),
    ('CHK1029', 4500, 'Checking', 83, 1),
    ('SAV2030', 3200, 'Savings', 84, 2),
    ('BUS3029', 99000, 'Business', 85, 3),
    ('CHK1030', 780, 'Checking', 86, 1),
    ('SAV2031', 11000, 'Savings', 87, 2),
    ('BUS3030', 75000, 'Business', 88, 3),
    ('CHK1031', 5600, 'Checking', 89, 1),
    ('SAV2032', 4500, 'Savings', 90, 2),
    ('BUS3031', 88000, 'Business', 91, 3),
    ('CHK1032', 2300, 'Checking', 92, 1),
    ('SAV2033', 6700, 'Savings', 93, 2),
    ('BUS3032', 54000, 'Business', 94, 3),
    ('CHK1033', 1200, 'Checking', 95, 1),
    ('SAV2034', 9100, 'Savings', 96, 2),
    ('BUS3033', 150000, 'Business', 97, 3),
    ('CHK1034', 300, 'Checking', 98, 1),
    ('SAV2035', 4500, 'Savings', 99, 2),
    ('BUS3034', 62000, 'Business', 100, 3);