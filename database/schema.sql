CREATE TABLE IF NOT EXISTS users (
    id         INTEGER  PRIMARY KEY AUTOINCREMENT,
    username   TEXT     NOT NULL UNIQUE,
    password   TEXT     NOT NULL,
    role       TEXT     NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id   INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT    NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS products (
    id              INTEGER  PRIMARY KEY AUTOINCREMENT,
    reference       TEXT     NOT NULL UNIQUE,
    name            TEXT     NOT NULL,
    category_id     INTEGER,
    price           REAL     NOT NULL DEFAULT 0,
    quantity        INTEGER  NOT NULL DEFAULT 0,
    alert_threshold INTEGER  NOT NULL DEFAULT 5,
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(category_id) REFERENCES categories(id)
);

CREATE TABLE IF NOT EXISTS stock_movements (
    id            INTEGER  PRIMARY KEY AUTOINCREMENT,
    product_id    INTEGER  NOT NULL,
    user_id       INTEGER,
    movement_type TEXT     NOT NULL,
    quantity      INTEGER  NOT NULL,
    created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(product_id) REFERENCES products(id),
    FOREIGN KEY(user_id)    REFERENCES users(id)
);
