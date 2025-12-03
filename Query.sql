-- 1. Insérer un nouveau customer
INSERT INTO
    Customers (full_name, email, phone, registration_date)
VALUES
    (
        'Zakaria',
        'zakaria@example.com',
        '0645678901',
        '2025-12-04'
    );

-- 2. Modifier le numéro de téléphone d’un customer
UPDATE Customers
SET
    phone = '0656789012'
WHERE
    customer_id = 1;

-- 3. Afficher tous les customers
SELECT
    *
FROM
    Customers;

-- 4. Afficher uniquement full_name et email des customers
SELECT
    full_name,
    email
FROM
    Customers;

-- 5. Afficher tous les accounts
SELECT
    *
FROM
    Accounts;

-- 6. Afficher uniquement account_number
SELECT
    account_number
FROM
    Accounts;

-- 7. Afficher toutes les transactions
SELECT
    *
FROM
    Transactions;

-- 8. Afficher les accounts avec un balance > 10000
SELECT
    *
FROM
    Accounts
WHERE
    balance > 10000;

-- 9. Afficher les accounts avec un balance ≤ 0
SELECT
    *
FROM
    Accounts
WHERE
    balance <= 0;