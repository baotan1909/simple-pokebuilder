-- Users table --
CREATE TABLE users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  email TEXT UNIQUE,
  name TEXT,                     -- Display name
  avatar TEXT,
  provider TEXT NOT NULL,        -- 'google', 'facebook'
  provider_id TEXT,              -- OAuth ID
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Pokemon team table --
CREATE TABLE teams (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER NOT NULL,
  name TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Likes table --
CREATE TABLE team_likes (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER NOT NULL,
  team_id INTEGER NOT NULL,
  liked_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE(user_id, team_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE
);

-- Pokemon table --
CREATE TABLE pokemons (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  team_id INTEGER NOT NULL,
  species TEXT NOT NULL,
  dex_number INTEGER NOT NULL,
  FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE
);