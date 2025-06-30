CREATE TABLE IF NOT EXISTS groups(  
    id uuid NOT NULL PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(255),
    description VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS roles(  
    id uuid NOT NULL PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(255),
    level INT
);

CREATE TABLE IF NOT EXISTS users(  
    id uuid NOT NULL PRIMARY KEY DEFAULT gen_random_uuid(),
    username VARCHAR(255),
    password VARCHAR(255),
    full_name VARCHAR(255),
    role_id INT,             
    group_id INT, 
    create_time DATE,
    CONSTRAINT fk_role FOREIGN KEY (role_id) REFERENCES roles(id),
    CONSTRAINT fk_group FOREIGN KEY (group_id) REFERENCES groups(id)
);

COMMENT ON TABLE users IS 'Stores user account information';
COMMENT ON COLUMN users.username IS 'Login username';
COMMENT ON COLUMN users.role_id IS 'Foreign key to roles table';
COMMENT ON COLUMN users.group_id IS 'Foreign key to groups table';