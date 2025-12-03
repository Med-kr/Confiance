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

-- 10. Afficher les transactions de type "debit"
SELECT
    *
FROM
    Transactions
WHERE
    transaction_type = 'debit';

-- 11. Afficher les transactions de type "credit"
SELECT
    *
FROM
    Transactions
WHERE
    transaction_type = 'credit';

-- 12. Afficher les transactions du account_id = 1
SELECT
    *
FROM
    Transactions
WHERE
    account_id = 1;

-- 13. Afficher les customers ayant un account géré par l’advisor_id = 2
SELECT DISTINCT
    c.*
FROM
    Customers c
    JOIN Accounts a ON c.customer_id = a.customer_id
WHERE
    a.advisor_id = 2;

-- 14. Afficher les accounts ayant account_type = "Savings"
SELECT
    *
FROM
    Accounts
WHERE
    account_type = 'Savings';

-- 15. Afficher les transactions avec un amount ≥ 500
SELECT
    *
FROM
    Transactions
WHERE
    amount >= 500;

-- 16. Afficher les transactions avec un amount entre 100 et 1000
SELECT
    *
FROM
    Transactions
WHERE
    amount BETWEEN 100 AND 1000;

-- 17. Afficher les accounts du customer_id = 1
SELECT
    *
FROM
    Accounts
WHERE
    customer_id = 1;

-- 18. Afficher les accounts triés par balance (ordre croissant)
SELECT
    *
FROM
    Accounts
ORDER BY
    balance ASC;

-- 19. Afficher les transactions triées par amount (ordre décroissant)
SELECT
    *
FROM
    Transactions
ORDER BY
    amount DESC;

-- 20. Afficher les 5 plus grandes transactions
SELECT
    *
FROM
    Transactions
ORDER BY
    amount DESC
LIMIT
    5;

-- 21. Afficher toutes les transactions triées par transaction_date décroissante            
SELECT
    *
FROM
    Transactions
ORDER BY
    transaction_date DESC;

-- 22. Afficher les 3 dernières transactions
SELECT
    *
FROM
    Transactions
ORDER BY
    transaction_date DESC
LIMIT
    3;

-- 23. Afficher chaque account avec le nom du customer et le nom de l’advisor
SELECT
    a.account_number,
    c.full_name AS customer_name,
    ad.full_name AS advisor_name
FROM
    Accounts a
    JOIN Customers c ON a.customer_id = c.customer_id
    JOIN Advisors ad ON a.advisor_id = ad.advisor_id;

-- Bonus 1: Compter le nombre de transactions par account
SELECT
    account_id,
    COUNT(*) AS total_transactions
FROM
    Transactions
GROUP BY
    account_id;

-- Bonus 2: Afficher le total du balance de tous les accounts d’un customer
SELECT
    customer_id,
    SUM(balance) AS total_balance
FROM
    Accounts
GROUP BY
    customer_id;

-- Bonus 4: Afficher le total des montants debit et credit par account
SELECT
    account_id,
    SUM(
        CASE
            WHEN transaction_type = 'debit' THEN amount
            ELSE 0
        END
    ) AS total_debit,
    SUM(
        CASE
            WHEN transaction_type = 'credit' THEN amount
            ELSE 0
        END
    ) AS total_credit
FROM
    Transactions
GROUP BY
    account_id;