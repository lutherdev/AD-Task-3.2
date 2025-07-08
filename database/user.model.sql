CREATE TABLE IF NOT EXISTS groups(  
    id INTEGER NOT NULL PRIMARY KEY,
    name VARCHAR(255),
    description VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS roles(  
    id INTEGER NOT NULL PRIMARY KEY,
    name VARCHAR(255),
    level INT
);
DROP TABLE IF EXISTS users CASCADE;
CREATE TABLE IF NOT EXISTS users(  
    id uuid NOT NULL PRIMARY KEY DEFAULT gen_random_uuid(),
    username VARCHAR(255),
    password VARCHAR(255),
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    role_id INTEGER REFERENCES roles(id) ON DELETE SET NULL,
    group_id INTEGER REFERENCES groups(id) ON DELETE SET NULL           
);

COMMENT ON TABLE users IS 'Stores user account information';
COMMENT ON COLUMN users.username IS 'Login username';
COMMENT ON COLUMN users.role_id IS 'Foreign key to roles table';
COMMENT ON COLUMN users.group_id IS 'Foreign key to groups table';
