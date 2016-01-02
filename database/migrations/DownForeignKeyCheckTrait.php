<?php

/**
 * trait DownForeignKeyCheckTrait
 */
trait DownForeignKeyCheckTrait
{

    /**
     * @return void
     */
    public function down()
    {
        $this->disableForeignKeyCheck();
        Schema::drop($this->table);
        $this->enableForeignKeyCheck();
    }

    /**
     * @return bool|null
     */
    protected function disableForeignKeyCheck()
    {
        switch (\DB::getDriverName()) {
            case "sqlite":
                return \DB::statement('PRAGMA foreign_keys = OFF');
                break;
            case "mysql":
                return \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * @return bool|null
     */
    protected function enableForeignKeyCheck()
    {
        switch (\DB::getDriverName()) {
            case "sqlite":
                return \DB::statement('PRAGMA foreign_keys = ON');
                break;
            case "mysql":
                return \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
                break;
            default:
                return null;
                break;
        }
    }
}
