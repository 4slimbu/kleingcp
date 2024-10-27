CREATE TABLE profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Auto-incrementing ID for unique identification
    priority ENUM('daily', 'intermittent', 'random', 'testing', 'celebrity') NOT NULL,  -- Enum for priority options
    name VARCHAR(255) NOT NULL,          -- Name field
    link VARCHAR(1000) NOT NULL,         -- Link field, updated to allow 1000 characters
    bell TINYINT(1) NOT NULL DEFAULT 0,  -- Bell notification as a boolean (0 or 1)
    status TINYINT(1) NOT NULL DEFAULT 0, -- Status as a boolean (0 or 1)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Timestamp for when the record was created
);


INSERT INTO profiles (priority, name, link, bell, status) VALUES
('daily', 'John Doe', 'https://example.com/johndoe', 1, 1),
('intermittent', 'Jane Smith', 'https://example.com/janesmith', 0, 1),
('random', 'Alice Johnson', 'https://example.com/alicejohnson', 1, 0),
('testing', 'Bob Brown', 'https://example.com/bobbrown', 0, 1),
('celebrity', 'Charlie Black', 'https://example.com/charlieblack', 1, 1);

