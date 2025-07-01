CREATE TABLE IF NOT EXISTS meeting_users (
    meetings_id uuid NOT NULL REFERENCES meetings (id),
    user_id uuid NOT NULL REFERENCES users (id),
    PRIMARY KEY (meetings_id, user_id)
);