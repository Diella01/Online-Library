USE ONLIBRARY;
CREATE TABLE users (
 id INT IDENTITY(1,1) PRIMARY KEY,
 name NVARCHAR(100),
 email NVARCHAR(100) UNIQUE,
 password NVARCHAR(255),
 role NVARCHAR(20) DEFAULT 'user',
 created_at DATETIME DEFAULT GETDATE()
);

CREATE TABLE books (
 id INT IDENTITY(1,1) PRIMARY KEY,
 title NVARCHAR(200),
 description NVARCHAR(MAX),
 cover_image NVARCHAR(255),
 pdf_file NVARCHAR(255),
 created_by INT,
 created_at DATETIME DEFAULT GETDATE()
);
CREATE TABLE news (
 id INT IDENTITY(1,1) PRIMARY KEY,
 title NVARCHAR(200),
 content NVARCHAR(MAX),
 image NVARCHAR(255),
 created_by INT,
 created_at DATETIME DEFAULT GETDATE()
);
CREATE TABLE contacts (
 id INT IDENTITY(1,1) PRIMARY KEY,
 name NVARCHAR(100),
 email NVARCHAR(100),
 message NVARCHAR(MAX),
 created_at DATETIME DEFAULT GETDATE()
);
CREATE TABLE pages (
 id INT IDENTITY(1,1) PRIMARY KEY,
 page_key NVARCHAR(50),
 title NVARCHAR(200),
 content NVARCHAR(MAX),
 updated_by INT
);
