drop table if exists posts, comments , users, likes, deletedUsers, deletedPosts, deletedComments;

create table users (
    id int auto_increment primary key not null,
    name varchar(50),
    email varchar(255) unique,
    password varchar(255),
    created_at DATETIME default now(),
    accessLevel smallint default 0,
    userProfilePic text
);

create table posts (
    id int auto_increment primary key not null,
    user_id int not null,
    title varchar(75),
    body text,
    created_at DATETIME default now(),
    imageUrl text,
    FOREIGN KEY (user_id) references users(id) on delete cascade
);

create table comments (
    id int auto_increment primary key not null,
    comment varchar(50),
    user_id int not null,
    post_id int not null,
    visible int,
    FOREIGN KEY (user_id) references users(id) on delete cascade,
    FOREIGN KEY (post_id) references posts(id) on delete cascade
);

create table likes (
    user_id int not null,
    post_id int not null,
    PRIMARY KEY (user_id, post_id),
    FOREIGN KEY (user_id) references users(id) on delete cascade,
    FOREIGN KEY (post_id) references posts(id) on delete cascade
);

create table deletedComments(
    id int,
    comment text,
    user_id int,
    post_id int,
    visible int
);

create table deletedUsers(
    id int,
    name varchar(50),
    email varchar(255),
    password varchar(255),
    deleted_at datetime,
    accessLevel smallint,
    userProfilePic text
);

create table deletedPosts(
    id int,
    user_id int,
    title varchar(255),
    body text,
    deleted_at datetime,
    imageUrl text
);
