<?php

namespace Craft;

/**
 * The class name is the UTC timestamp in the format of mYYMMDD_HHMMSS_pluginHandle_migrationName
 */
class m171026_093800_seomatic_addFacebookAdminId extends BaseMigration
{
    /**
     * Any migration code in here is wrapped inside of a transaction.
     *
     * @return bool
     */
    public function safeUp()
    {
        $newColumns = [
            'facebookAdminId' => ColumnType::Varchar,
        ];

        $this->_addColumnsAfter('seomatic_settings', $newColumns, 'facebookAppId');
        $this->alterColumn('seomatic_settings', 'facebookAdminId', array(ColumnType::Varchar, 'maxLength' => 255));

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
