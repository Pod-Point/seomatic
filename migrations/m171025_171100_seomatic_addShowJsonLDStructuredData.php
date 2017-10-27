<?php

namespace Craft;

/**
 * The class name is the UTC timestamp in the format of mYYMMDD_HHMMSS_pluginHandle_migrationName
 */
class m171025_171100_seomatic_addShowJsonLDStructuredData extends BaseMigration
{
    /**
     * Any migration code in here is wrapped inside of a transaction.
     *
     * @return bool
     */
    public function safeUp()
    {
        $newColumns = [
            'seoShowIdentity' => ColumnType::Bool,
            'seoShowWebsite' => ColumnType::Bool,
            'seoShowPlace' => ColumnType::Bool,
            'seoShowMainEntity' => ColumnType::Bool,
        ];

        $this->_addColumnsAfter('seomatic_meta', $newColumns, 'robots');

        return true;
    }

    private function _addColumnsAfter($tableName, $newColumns, $afterColumnHandle)
    {
        foreach ($newColumns as $columnName => $columnType) {
            if (!craft()->db->columnExists($tableName, $columnName))
            {
                $this->addColumnAfter($tableName, $columnName, [
                        'column' => $columnType,
                        'null'   => false,
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
