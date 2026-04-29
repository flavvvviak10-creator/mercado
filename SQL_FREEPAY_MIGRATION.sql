-- ============================================================
-- FreePay Brasil - Script de Migração do Banco de Dados
-- Execute este script UMA VEZ no seu banco MySQL/MariaDB
-- para adicionar suporte ao gateway FreePay
-- ============================================================

-- 1. Adicionar colunas FreePay na tabela 'pix' (se não existirem)
ALTER TABLE `pix`
  ADD COLUMN IF NOT EXISTS `freepay_public_key` TEXT NOT NULL DEFAULT '',
  ADD COLUMN IF NOT EXISTS `freepay_secret_key` TEXT NOT NULL DEFAULT '',
  ADD COLUMN IF NOT EXISTS `use_freepay` TINYINT(1) NOT NULL DEFAULT 0;

-- 2. Adicionar colunas de rastreamento FreePay na tabela 'pixgerado'
ALTER TABLE `pixgerado`
  ADD COLUMN IF NOT EXISTS `freepay_transaction_id` TEXT NOT NULL DEFAULT '',
  ADD COLUMN IF NOT EXISTS `freepay_status` TEXT NOT NULL DEFAULT 'PENDING';

-- ============================================================
-- Verificação: Execute este SELECT para confirmar as colunas
-- SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
--   WHERE TABLE_NAME = 'pix' AND TABLE_SCHEMA = DATABASE();
-- ============================================================
