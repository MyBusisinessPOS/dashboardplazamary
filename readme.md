## Insertar en usuarios el default

- Usuario: admin@admin.com
- Contraseña: secret

# Tipo encriptado sha1(md5('string'))

- INSERT INTO users (name,email,email_verified_at,password,remember_token,created_at,updated_at) VALUES
	 ('Administrador','admin@admin.com',NULL,'f2ba704225c5c7ee676f3201ea256bf5779e6877',NULL,NULL,NULL);