ALTER TABLE users ADD role_id BIGINT UNSIGNED NOT NULL;
ALTER TABLE users ADD deleted_at datetime;

UPDATE users SET role_id = 1 

ALTER TABLE users ADD CONSTRAINT users_fk FOREIGN KEY (role_id) REFERENCES todobarato_dashboard.roles(id);