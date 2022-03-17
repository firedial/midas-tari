
-- 外部キー制約を一時的に無視する
SET FOREIGN_KEY_CHECKS = 0;

-- 不要なテーブルのドロップ
DROP TABLE m_kind_group_relation;
DROP TABLE m_kind_group;
DROP TABLE m_purpose_group_relation;
DROP TABLE m_purpose_group;
DROP TABLE m_place_group_relation;
DROP TABLE m_place_group;

-- 各 element の id を一つ大きくする
UPDATE m_kind_element SET kind_element_id = kind_element_id + 1 ORDER BY kind_element_id DESC;
UPDATE m_purpose_element SET purpose_element_id = purpose_element_id + 1 ORDER BY purpose_element_id DESC;
UPDATE m_place_element SET place_element_id = place_element_id + 1 ORDER BY place_element_id DESC;
-- それに応じて参照元も修正
UPDATE m_balance SET kind_element_id = kind_element_id + 1, purpose_element_id = purpose_element_id + 1, place_element_id = place_element_id + 1;

-- 各 category の id を一つ大きくする
UPDATE m_kind_category SET kind_category_id = kind_category_id + 1 ORDER BY kind_category_id DESC;
UPDATE m_purpose_category SET purpose_category_id = purpose_category_id + 1 ORDER BY purpose_category_id DESC;
UPDATE m_place_category SET place_category_id = place_category_id + 1 ORDER BY place_category_id DESC;
-- それに応じて参照元も修正
UPDATE m_kind_element SET kind_category_id = kind_category_id + 1;
UPDATE m_purpose_element SET purpose_category_id = purpose_category_id + 1;
UPDATE m_place_element SET place_category_id = place_category_id + 1;

-- category
-- id = 1 が空いたのでそこに移動処理を入れる
-- 古い物は古いものとわかるように更新
UPDATE m_kind_category SET kind_category_name = 'Old_move' WHERE kind_category_id = 7;
INSERT INTO m_kind_category VALUE (1, 'Move', '移動');
UPDATE m_purpose_category SET purpose_category_name = 'Old_move' WHERE purpose_category_id = 4;
INSERT INTO m_purpose_category VALUE (1, 'Move', '移動');
UPDATE m_place_category SET place_category_name = 'Old_move' WHERE place_category_id = 9;
INSERT INTO m_place_category VALUE (1, 'Move', '移動');

-- element
-- id = 1 が空いたのでそこに移動処理を入れる
-- 古い物は古いものとわかるように更新
UPDATE m_kind_element SET kind_element_name = 'old_move' WHERE kind_element_id = 15;
INSERT INTO m_kind_element VALUE (1, 'move', '移動', 1);
UPDATE m_purpose_element SET purpose_element_name = 'old_move' WHERE purpose_element_id = 13;
INSERT INTO m_purpose_element VALUE (1, 'move', '移動', 1);
UPDATE m_place_element SET place_element_name = 'old_move' WHERE place_element_id = 5;
INSERT INTO m_place_element VALUE (1, 'move', '移動', 1);

-- 既存のやつを 1 に合わせる
UPDATE m_balance SET kind_element_id = 1 WHERE kind_element_id = 15;
UPDATE m_balance SET purpose_element_id = 1 WHERE purpose_element_id = 13;
UPDATE m_balance SET place_element_id = 1 WHERE place_element_id = 5;

-- 外部キー制約のチェックを元に戻す
SET FOREIGN_KEY_CHECKS = 1;

