SELECT 
m_balance.balance_id,
m_balance.amount,
m_balance.date,
m_balance.item,
m_kind_element.kind_element_name,
m_purpose_element.purpose_element_name,
m_place_element.place_element_name
FROM m_balance
JOIN m_kind_element USING(kind_element_id)
JOIN m_purpose_element USING(purpose_element_id)
JOIN m_place_element USING(place_element_id)
ORDER BY balance_id;
