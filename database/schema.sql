-- ============================================================
-- নবদুর্গা (Navadurga) — Database Schema
-- Engine: InnoDB | Charset: utf8mb4_unicode_ci (Bengali-safe)
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------
-- roles
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL UNIQUE COMMENT 'user, admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role_id INT UNSIGNED NOT NULL DEFAULT 1,
    avatar VARCHAR(255) NULL,
    status ENUM('active','banned') NOT NULL DEFAULT 'active',
    email_verified_at DATETIME NULL,
    remember_token VARCHAR(100) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT,
    INDEX idx_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- navadurga — 9 forms
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS navadurga (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    day_number TINYINT UNSIGNED NOT NULL UNIQUE,
    name_bn VARCHAR(150) NOT NULL,
    name_en VARCHAR(150) NULL,
    sanskrit_name VARCHAR(150) NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    alternative_names VARCHAR(255) NULL,
    short_description TEXT NULL,
    detailed_description LONGTEXT NULL,
    name_meaning TEXT NULL,
    traditional_symbolism TEXT NULL,
    iconography TEXT NULL,
    vehicle VARCHAR(150) NULL,
    hands VARCHAR(50) NULL,
    weapons VARCHAR(255) NULL,
    objects VARCHAR(255) NULL,
    colour VARCHAR(100) NULL,
    associated_quality VARCHAR(255) NULL,
    associated_chakra VARCHAR(100) NULL,
    traditional_association TEXT NULL,
    traditional_food VARCHAR(255) NULL,
    puja_significance TEXT NULL,
    story LONGTEXT NULL,
    mantra TEXT NULL,
    stotra TEXT NULL,
    scriptural_sources TEXT NULL COMMENT 'source citations, never fabricated',
    regional_variations TEXT NULL,
    modern_interpretation TEXT NULL,
    seva_note TEXT NULL COMMENT 'website suggested seva disclaimer text',
    image VARCHAR(255) NULL,
    seo_title VARCHAR(255) NULL,
    seo_description VARCHAR(500) NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_navadurga_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- navaratri_days — evergreen 9-day content template
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS navaratri_days (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    day_number TINYINT UNSIGNED NOT NULL UNIQUE,
    navadurga_id INT UNSIGNED NOT NULL,
    date DATE NULL COMMENT 'convenience cache of current year date; authoritative per-year dates live in festival_calendar',
    tithi VARCHAR(100) NULL,
    title_bn VARCHAR(255) NULL,
    theme VARCHAR(255) NULL,
    traditional_focus TEXT NULL,
    puja_focus TEXT NULL,
    spiritual_focus TEXT NULL,
    learning_focus TEXT NULL,
    family_activity TEXT NULL,
    children_activity TEXT NULL,
    environment_activity TEXT NULL,
    seva_easy TEXT NULL,
    seva_moderate TEXT NULL,
    seva_challenging TEXT NULL,
    recommended_items TEXT NULL,
    daily_mantra TEXT NULL,
    daily_message TEXT NULL,
    avoid_note TEXT NULL,
    image VARCHAR(255) NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_navaratri_days_navadurga FOREIGN KEY (navadurga_id) REFERENCES navadurga(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- festival_calendar — per-year concrete dates (admin editable yearly)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS festival_calendar (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    year SMALLINT UNSIGNED NOT NULL,
    day_number TINYINT UNSIGNED NULL COMMENT 'NULL for special markers e.g. Mahalaya/Dashami',
    gregorian_date DATE NOT NULL,
    tithi VARCHAR(100) NULL,
    navadurga_id INT UNSIGNED NULL,
    event_label VARCHAR(255) NULL,
    is_dashami TINYINT(1) NOT NULL DEFAULT 0,
    notes VARCHAR(500) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_calendar_navadurga FOREIGN KEY (navadurga_id) REFERENCES navadurga(id) ON DELETE SET NULL,
    INDEX idx_calendar_year (year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- sevas
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS sevas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title_bn VARCHAR(255) NOT NULL,
    title_en VARCHAR(255) NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category VARCHAR(100) NOT NULL,
    description TEXT NULL,
    beneficiary VARCHAR(150) NULL,
    difficulty ENUM('সহজ','মাঝারি','কঠিন') NOT NULL DEFAULT 'সহজ',
    estimated_cost VARCHAR(100) NULL COMMENT 'display text e.g. ৳0-100',
    estimated_cost_min INT UNSIGNED NULL,
    estimated_cost_max INT UNSIGNED NULL,
    time_required VARCHAR(100) NULL COMMENT 'display text e.g. 30 minutes',
    time_required_minutes INT UNSIGNED NULL COMMENT 'for filtering; large sentinel used for long-term',
    materials TEXT NULL,
    how_to TEXT NULL,
    safety_note TEXT NULL,
    navadurga_day TINYINT UNSIGNED NULL,
    impact_level VARCHAR(100) NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_sevas_slug (slug),
    INDEX idx_sevas_category (category),
    INDEX idx_sevas_day (navadurga_day)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- puja_items
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS puja_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name_bn VARCHAR(255) NOT NULL,
    name_en VARCHAR(255) NULL,
    category VARCHAR(100) NOT NULL,
    quantity VARCHAR(50) NULL,
    unit VARCHAR(50) NULL,
    used_day VARCHAR(100) NULL COMMENT 'e.g. all days / day 1,4,8',
    importance VARCHAR(50) NULL COMMENT 'আবশ্যক / ঐচ্ছিক',
    alternative VARCHAR(255) NULL,
    notes TEXT NULL,
    image VARCHAR(255) NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_puja_items_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- mantras
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS mantras (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title_bn VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    sanskrit TEXT NULL,
    transliteration TEXT NULL,
    pronunciation_bn TEXT NULL,
    meaning_bn TEXT NULL,
    meaning_en TEXT NULL,
    associated_deity VARCHAR(150) NULL,
    associated_day TINYINT UNSIGNED NULL,
    source VARCHAR(255) NULL COMMENT 'never fabricated; leave NULL if unverified',
    audio_url VARCHAR(255) NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_mantras_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- categories (generic — articles, gallery, etc.)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name_bn VARCHAR(150) NOT NULL,
    name_en VARCHAR(150) NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    type VARCHAR(30) NOT NULL DEFAULT 'article',
    parent_id INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_categories_parent FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_categories_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- tags
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tags (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- articles
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS articles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title_bn VARCHAR(255) NOT NULL,
    title_en VARCHAR(255) NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt TEXT NULL,
    content LONGTEXT NULL,
    category_id INT UNSIGNED NULL,
    author VARCHAR(150) NULL,
    featured_image VARCHAR(255) NULL,
    source VARCHAR(255) NULL,
    reading_time VARCHAR(30) NULL,
    seo_title VARCHAR(255) NULL,
    seo_description VARCHAR(500) NULL,
    status ENUM('draft','published') NOT NULL DEFAULT 'draft',
    published_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_articles_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_articles_slug (slug),
    FULLTEXT INDEX ftx_articles_search (title_bn, excerpt, content)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS article_tags (
    article_id INT UNSIGNED NOT NULL,
    tag_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (article_id, tag_id),
    CONSTRAINT fk_at_article FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    CONSTRAINT fk_at_tag FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- gallery
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS gallery (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    caption VARCHAR(500) NULL,
    category VARCHAR(100) NULL,
    credit_source VARCHAR(255) NULL,
    alt_text VARCHAR(255) NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- faqs
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS faqs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question_bn VARCHAR(500) NOT NULL,
    answer_bn TEXT NOT NULL,
    category VARCHAR(100) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- children / family / environment activities
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS children_activities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    age_group VARCHAR(100) NULL,
    duration VARCHAR(100) NULL,
    materials TEXT NULL,
    instructions TEXT NULL,
    learning_outcome TEXT NULL,
    day_number TINYINT UNSIGNED NULL,
    image VARCHAR(255) NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS family_activities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title_bn VARCHAR(255) NOT NULL,
    description TEXT NULL,
    category VARCHAR(100) NULL,
    duration VARCHAR(100) NULL,
    materials TEXT NULL,
    instructions TEXT NULL,
    day_number TINYINT UNSIGNED NULL,
    image VARCHAR(255) NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS environment_activities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title_bn VARCHAR(255) NOT NULL,
    why_text TEXT NULL,
    how_text TEXT NULL,
    materials_needed TEXT NULL,
    difficulty ENUM('সহজ','মাঝারি','কঠিন') NOT NULL DEFAULT 'সহজ',
    estimated_cost VARCHAR(100) NULL,
    time_required VARCHAR(100) NULL,
    image VARCHAR(255) NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- checklist system (puja planning + daily guide)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS checklist_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    phase VARCHAR(30) NOT NULL DEFAULT 'day' COMMENT 'before, day, dashami',
    day_number TINYINT UNSIGNED NULL COMMENT 'NULL when phase=before or dashami',
    label_bn VARCHAR(255) NOT NULL,
    category VARCHAR(100) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS user_checklist_status (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    checklist_item_id INT UNSIGNED NOT NULL,
    status ENUM('not_started','completed') NOT NULL DEFAULT 'not_started',
    completed_at DATETIME NULL,
    UNIQUE KEY uq_user_checklist (user_id, checklist_item_id),
    CONSTRAINT fk_ucs_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_ucs_item FOREIGN KEY (checklist_item_id) REFERENCES checklist_items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- user puja item status (purchased / prepared)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS user_puja_status (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    puja_item_id INT UNSIGNED NOT NULL,
    purchased TINYINT(1) NOT NULL DEFAULT 0,
    prepared TINYINT(1) NOT NULL DEFAULT 0,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_user_puja_item (user_id, puja_item_id),
    CONSTRAINT fk_ups_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_ups_item FOREIGN KEY (puja_item_id) REFERENCES puja_items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- user seva logs
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS user_seva_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    seva_id INT UNSIGNED NULL,
    custom_title VARCHAR(255) NULL,
    navadurga_day TINYINT UNSIGNED NULL,
    note TEXT NULL,
    completed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usl_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_usl_seva FOREIGN KEY (seva_id) REFERENCES sevas(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- bookmarks
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS bookmarks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    item_type ENUM('navadurga','seva','article','mantra') NOT NULL,
    item_id INT UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_bookmark (user_id, item_type, item_id),
    CONSTRAINT fk_bookmarks_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- family challenge log (section 38) + daily reflections (section 39)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS family_challenge_log (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    day_number TINYINT UNSIGNED NOT NULL,
    status ENUM('pending','completed','skipped') NOT NULL DEFAULT 'pending',
    note TEXT NULL,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_family_challenge (user_id, day_number),
    CONSTRAINT fk_fcl_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS daily_reflections (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    day_number TINYINT UNSIGNED NOT NULL,
    learned_text TEXT NULL,
    helped_text TEXT NULL,
    change_text TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_dr_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- gamification (section 40) — kept simple, no competitive ranking
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS badges (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    title_bn VARCHAR(150) NOT NULL,
    description_bn VARCHAR(255) NULL,
    icon VARCHAR(50) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS user_badges (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    badge_id INT UNSIGNED NOT NULL,
    earned_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_user_badge (user_id, badge_id),
    CONSTRAINT fk_ub_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_ub_badge FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- contact messages
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new','read') NOT NULL DEFAULT 'new',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- site settings (key-value)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS site_settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(100) NOT NULL UNIQUE,
    `value` TEXT NULL,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
