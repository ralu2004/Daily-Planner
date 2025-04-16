create table users
(
    id         serial
        primary key,
    name       varchar(255) not null,
    email      varchar(255) not null
        unique
        constraint unique_email
            unique
        constraint check_email_format
            check ((email)::text ~* '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$'::text),
    password   varchar(255) not null,
    created_at timestamp default CURRENT_TIMESTAMP
);

alter table users
    owner to postgres;

create index idx_email
    on users (email);

create table categories
(
    id   serial
        primary key,
    name varchar(255) not null
        unique
);

alter table categories
    owner to postgres;

create table tasks
(
    id          serial
        primary key,
    title       varchar(255) not null,
    description text,
    due_date    timestamp,
    priority    varchar(50),
    user_id     integer      not null
        references users
            on update restrict on delete restrict,
    category_id integer
        references categories
            on update restrict on delete restrict,
    created_at  timestamp default CURRENT_TIMESTAMP
);

alter table tasks
    owner to postgres;

create table events
(
    id          serial
        primary key,
    title       varchar(255) not null,
    description text,
    start_time  timestamp    not null,
    end_time    timestamp    not null,
    user_id     integer      not null
        references users
            on update restrict on delete restrict,
    created_at  timestamp default CURRENT_TIMESTAMP
);

alter table events
    owner to postgres;

create table notifications
(
    id         serial
        primary key,
    type       varchar(255) not null,
    message    text         not null,
    task_id    integer
        references tasks
            on update restrict on delete restrict,
    event_id   integer
        references events
            on update restrict on delete restrict,
    user_id    integer      not null
        references users
            on update restrict on delete restrict,
    created_at timestamp default CURRENT_TIMESTAMP
);

alter table notifications
    owner to postgres;

create table attachments
(
    id         serial
        primary key,
    file_path  varchar(255) not null,
    task_id    integer
        references tasks
            on update restrict on delete restrict,
    event_id   integer
        references events
            on update restrict on delete restrict,
    created_at timestamp default CURRENT_TIMESTAMP
);

alter table attachments
    owner to postgres;

create table tags
(
    id   serial
        primary key,
    name varchar(255) not null
        unique
);

alter table tags
    owner to postgres;

create table task_tags
(
    task_id integer not null
        references tasks
            on update restrict on delete restrict,
    tag_id  integer not null
        references tags
            on update restrict on delete restrict,
    primary key (task_id, tag_id)
);

alter table task_tags
    owner to postgres;

create table recurring_events
(
    id                 serial
        primary key,
    event_id           integer not null
        references events
            on update restrict on delete restrict,
    recurrence_pattern jsonb
);

alter table recurring_events
    owner to postgres;

create table audit_logs
(
    id         serial
        primary key,
    action     varchar(255),
    table_name varchar(255),
    record_id  integer,
    user_id    integer not null
        references users
            on update restrict on delete restrict,
    created_at timestamp default CURRENT_TIMESTAMP
);

alter table audit_logs
    owner to postgres;

create view tasks_current_month
            (task_id, task_title, task_description, task_due_date, task_priority, task_created_at, user_id, user_name,
             user_email, category_id, category_name)
as
SELECT t.id          AS task_id,
       t.title       AS task_title,
       t.description AS task_description,
       t.due_date    AS task_due_date,
       t.priority    AS task_priority,
       t.created_at  AS task_created_at,
       u.id          AS user_id,
       u.name        AS user_name,
       u.email       AS user_email,
       c.id          AS category_id,
       c.name        AS category_name
FROM tasks t
         JOIN users u ON t.user_id = u.id
         LEFT JOIN categories c ON t.category_id = c.id
WHERE EXTRACT(month FROM t.due_date) = EXTRACT(month FROM CURRENT_DATE)
  AND EXTRACT(year FROM t.due_date) = EXTRACT(year FROM CURRENT_DATE);

alter table tasks_current_month
    owner to postgres;

create view tasks_with_categories
            (task_id, title, description, due_date, priority, user_id, category_id, created_at, category_name) as
SELECT tasks.id        AS task_id,
       tasks.title,
       tasks.description,
       tasks.due_date,
       tasks.priority,
       tasks.user_id,
       tasks.category_id,
       tasks.created_at,
       categories.name AS category_name
FROM tasks
         JOIN categories ON tasks.category_id = categories.id;

alter table tasks_with_categories
    owner to postgres;

create view users_with_task_count(user_id, user_name, user_email, task_count) as
SELECT u.id        AS user_id,
       u.name      AS user_name,
       u.email     AS user_email,
       count(t.id) AS task_count
FROM users u
         LEFT JOIN tasks t ON u.id = t.user_id
GROUP BY u.id
ORDER BY (count(t.id)) DESC;

alter table users_with_task_count
    owner to postgres;

create view high_priority_tasks (task_id, title, description, due_date, priority, user_name, category, created_at) as
SELECT t.id   AS task_id,
       t.title,
       t.description,
       t.due_date,
       t.priority,
       u.name AS user_name,
       c.name AS category,
       t.created_at
FROM tasks t
         JOIN users u ON t.user_id = u.id
         JOIN categories c ON t.category_id = c.id
WHERE t.priority::text = 'High'::text
ORDER BY t.due_date;

alter table high_priority_tasks
    owner to postgres;

create view low_priority_tasks (task_id, title, description, due_date, priority, user_name, category, created_at) as
SELECT t.id   AS task_id,
       t.title,
       t.description,
       t.due_date,
       t.priority,
       u.name AS user_name,
       c.name AS category,
       t.created_at
FROM tasks t
         JOIN users u ON t.user_id = u.id
         JOIN categories c ON t.category_id = c.id
WHERE t.priority::text = 'Low'::text
ORDER BY t.due_date;

alter table low_priority_tasks
    owner to postgres;

create view medium_priority_tasks (task_id, title, description, due_date, priority, user_name, category, created_at) as
SELECT t.id   AS task_id,
       t.title,
       t.description,
       t.due_date,
       t.priority,
       u.name AS user_name,
       c.name AS category,
       t.created_at
FROM tasks t
         JOIN users u ON t.user_id = u.id
         JOIN categories c ON t.category_id = c.id
WHERE t.priority::text = 'Medium'::text
ORDER BY t.due_date;

alter table medium_priority_tasks
    owner to postgres;

create view overdue_tasks(task_id, title, due_date, user_name, user_email) as
SELECT t.id    AS task_id,
       t.title,
       t.due_date,
       u.name  AS user_name,
       u.email AS user_email
FROM tasks t
         JOIN users u ON t.user_id = u.id
WHERE t.due_date < CURRENT_TIMESTAMP
  AND t.due_date IS NOT NULL
ORDER BY t.due_date;

alter table overdue_tasks
    owner to postgres;

create view events_with_recurrence(event_id, event_title, start_time, end_time, recurrence_pattern) as
SELECT e.id    AS event_id,
       e.title AS event_title,
       e.start_time,
       e.end_time,
       r.recurrence_pattern
FROM events e
         LEFT JOIN recurring_events r ON e.id = r.event_id;

alter table events_with_recurrence
    owner to postgres;

create view notifications_summary
            (notification_id, type, message, task_id, task_title, event_id, event_title, user_id) as
SELECT n.id    AS notification_id,
       n.type,
       n.message,
       n.task_id,
       t.title AS task_title,
       n.event_id,
       e.title AS event_title,
       n.user_id
FROM notifications n
         LEFT JOIN tasks t ON n.task_id = t.id
         LEFT JOIN events e ON n.event_id = e.id;

alter table notifications_summary
    owner to postgres;

create view task_attachments(attachment_id, file_path, task_id, task_title) as
SELECT a.id    AS attachment_id,
       a.file_path,
       t.id    AS task_id,
       t.title AS task_title
FROM attachments a
         JOIN tasks t ON a.task_id = t.id
ORDER BY t.due_date;

alter table task_attachments
    owner to postgres;

create view audit_logs_by_action(action, table_name, action_count) as
SELECT action,
       table_name,
       count(id) AS action_count
FROM audit_logs
GROUP BY action, table_name
ORDER BY (count(id)) DESC;

alter table audit_logs_by_action
    owner to postgres;

create view tasks_with_tags(task_id, title, tag_name) as
SELECT t.id    AS task_id,
       t.title,
       tg.name AS tag_name
FROM tasks t
         JOIN task_tags tt ON t.id = tt.task_id
         JOIN tags tg ON tt.tag_id = tg.id;

alter table tasks_with_tags
    owner to postgres;

create view user_activity_overview(user_id, user_name, tasks_count, events_count) as
SELECT u.id                 AS user_id,
       u.name               AS user_name,
       count(DISTINCT t.id) AS tasks_count,
       count(DISTINCT e.id) AS events_count
FROM users u
         LEFT JOIN tasks t ON u.id = t.user_id
         LEFT JOIN events e ON u.id = e.user_id
GROUP BY u.id;

alter table user_activity_overview
    owner to postgres;


