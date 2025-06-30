CREATE TABLE IF NOT EXISTS meeting_users (
    meetings_id INTEGER NOT NULL REFERENCES meetings (id),
    user_id INTEGER NOT NULL REFERENCES users (id),
    PRIMARY KEY (meetings_id, user_id)
);