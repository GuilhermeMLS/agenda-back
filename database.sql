use agenda;

create table persons
(
    id         bigint auto_increment
        primary key,
    name       varchar(255) not null,
    company    varchar(255) null,
    birthday   date         null,
    email      varchar(255) null,
    created_at datetime     not null,
    updated_at datetime     not null
);

create table phones
(
    id         bigint auto_increment
        primary key,
    user_id    bigint       not null,
    phone      varchar(255) not null,
    created_at datetime     not null,
    updated_at datetime     not null,
    constraint fk_user_id
        foreign key (user_id) references persons (id)
            on delete cascade
);

INSERT INTO agenda.persons (id, name, company, birthday, email, created_at, updated_at) VALUES (197, 'João Moura', 'XPTO', '1996-08-25', 'joão@email.com', '2019-09-23 12:16:43', '2019-09-23 12:16:43');

INSERT INTO agenda.persons (id, name, company, birthday, email, created_at, updated_at) VALUES (198, 'Ana Nascimento', null, '1997-09-23', 'ana@email.com', '2019-09-23 12:17:09', '2019-09-23 12:17:09');

INSERT INTO agenda.persons (id, name, company, birthday, email, created_at, updated_at) VALUES (199, 'João XPTO', null, null, 'joao@email.com', '2019-09-23 12:17:47', '2019-09-23 12:18:44');

INSERT INTO agenda.persons (id, name, company, birthday, email, created_at, updated_at) VALUES (202, 'Guilherme Morais', null, null, 'guilherme@email.com', '2019-09-23 12:35:57', '2019-09-23 12:35:57');

INSERT INTO agenda.persons (id, name, company, birthday, email, created_at, updated_at) VALUES (203, 'Guilherme Morais Lopes', 'Polvo', null, null, '2019-09-23 12:36:08', '2019-09-23 12:40:42');

INSERT INTO agenda.persons (id, name, company, birthday, email, created_at, updated_at) VALUES (204, 'Barbara Rosa', 'Lorem Ipsum', null, 'barbara@email.com', '2019-09-23 12:38:27', '2019-09-23 12:38:50');

INSERT INTO agenda.persons (id, name, company, birthday, email, created_at, updated_at) VALUES (205, 'John Doe', 'Polvo Labs', '1997-08-25', 'john@email.com', '2019-09-23 12:41:46', '2019-09-23 12:41:46');

INSERT INTO agenda.phones (id, user_id, phone, created_at, updated_at) VALUES (500, 197, '(41) 996781918', '2019-09-23 12:17:23', '2019-09-23 12:17:23');

INSERT INTO agenda.phones (id, user_id, phone, created_at, updated_at) VALUES (501, 199, '(41) 31524456', '2019-09-23 12:17:56', '2019-09-23 12:17:56');

INSERT INTO agenda.phones (id, user_id, phone, created_at, updated_at) VALUES (502, 198, '(41) 99889787', '2019-09-23 12:18:10', '2019-09-23 12:18:10');

INSERT INTO agenda.phones (id, user_id, phone, created_at, updated_at) VALUES (505, 204, '(41) 997876767', '2019-09-23 12:38:27', '2019-09-23 12:38:27');

INSERT INTO agenda.phones (id, user_id, phone, created_at, updated_at) VALUES (506, 204, '997876767', '2019-09-23 12:38:27', '2019-09-23 12:38:27');

INSERT INTO agenda.phones (id, user_id, phone, created_at, updated_at) VALUES (507, 202, '995061518', '2019-09-23 12:39:38', '2019-09-23 12:39:38');

INSERT INTO agenda.phones (id, user_id, phone, created_at, updated_at) VALUES (508, 203, '(41) 995061518', '2019-09-23 12:39:53', '2019-09-23 12:39:53');
