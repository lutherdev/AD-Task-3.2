CREATE TABLE IF NOT EXISTS tasks (
    id INT PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    meetings_id INT,
    assigned_user_id INT,
    title VARCHAR(255),
    description TEXT,
    status VARCHAR(50), -- e.g. "Pending", "In Progress", "Done"
    due_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_task_meetings FOREIGN KEY (meetings_id) REFERENCES meetings(id),
    CONSTRAINT fk_task_user FOREIGN KEY (assigned_user_id) REFERENCES users(id)
);