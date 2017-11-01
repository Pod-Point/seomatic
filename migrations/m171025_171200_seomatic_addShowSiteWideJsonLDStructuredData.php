<?php

namespace Craft;

/**
 * The class name is the UTC timestamp in the format of mYYMMDD_HHMMSS_pluginHandle_migrationName
 */
class m171025_171200_seomatic_addShowSiteWideJsonLDStructuredData extends BaseMigration
{
    /**
     * Any migration code in here is wrapped inside of a transaction.
     *
     * @return bool
     */
    public function safeUp()
    {
        $newColumns = [
            'siteSeoShowIdentity' => ColumnType::Bool,
            'siteSeoShowWebsite' => ColumnType::Bool,
            'siteSeoShowPlace' => ColumnType::Bool,
            'siteSeoShowMainEntity' => ColumnType::Bool,
        ];

        $this->_addColumnsAfter('seomatic_settings', $newColumns, 'siteSeoImageId');

        return true;
    }

    private function _addColumnsAfter($tableName, $newColumns, $afterColumnHandle)
    {
        foreach ($newColumns as $columnName => $columnType) {
            if (!craft()->db->columnExists($tableName, $columnName))
            {
                $this->addColumnAfter($tableName, $columnName, [
                        'column' => $columnType,
                        'null'   => true,
                    ],
                    $afterColumnHandle
                );
                SeomaticPlugin::log("Created the `$columnName` in the `$tableName` table.", LogLevel::Info, true);
            } else {
                SeomaticPlugin::log("Column `$columnName` already exists in the `$tableName` table.", LogLevel::Info, true);
            }
        }
    }
}
