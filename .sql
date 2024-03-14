CREATE DATABASE newswebsite;

CREATE TABLE IF NOT EXISTS users(
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(100),
    email varchar(100) UNIQUE,
    password varchar(1000),
    gender ENUM("male","female"),
    role SET("admin","user") DEFAULT "user",
    image varchar(100)
    )

CREATE TABLE category(
                         created_by int,
                         FOREIGN KEY (created_by) REFERENCES users(id),
                         cid int PRIMARY KEY AUTO_INCREMENT,
                         name varchar(255) UNIQUE,
                         slug varchar(255) UNIQUE

);    


CREATE TABLE news(
                     nid int PRIMARY KEY AUTO_INCREMENT,
                     created_by int,
                     category_id int,
                     FOREIGN KEY (created_by) REFERENCES users(id),
                     FOREIGN KEY (category_id) REFERENCES category(cid),
                     title varchar(255),
                     slug varchar(255) UNIQUE,
                     image varchar(100),
                     summary text,
                     description text,
                     status ENUM("public","draft") DEFAULT "draft",
                     created_at date,
                     updated_at date,
                     meta_title text,
                     meta_description text,
                     page_views int

);