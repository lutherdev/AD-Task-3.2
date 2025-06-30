CREATE TABLE IF NOT EXISTS meetings (
    id uuid NOT NULL PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(255),
    description TEXT,
    start_date DATE,
    end_date DATE
);