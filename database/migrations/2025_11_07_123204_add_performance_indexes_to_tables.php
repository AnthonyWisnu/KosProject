<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tables and their index definitions.
     *
     * @var array<string, array<int, array<int, string>>>
     */
    private array $indexDefinitions = [
        'rooms' => [
            ['status'],
            ['room_type'],
            ['price'],
            ['status', 'room_type'],
        ],
        'tenants' => [
            ['room_id'],
            ['user_id'],
            ['status'],
            ['status', 'end_date'],
        ],
        'payments' => [
            ['tenant_id'],
            ['payment_status'],
            ['payment_date'],
            ['due_date'],
            ['payment_status', 'due_date'],
        ],
        'bookings' => [
            ['room_id'],
            ['status'],
            ['check_in_date'],
            ['check_out_date'],
            ['status', 'check_in_date'],
        ],
        'complaints' => [
            ['tenant_id'],
            ['room_id'],
            ['status'],
            ['priority'],
            ['status', 'priority'],
        ],
        'ratings' => [
            ['room_id'],
            ['user_id'],
            ['rating'],
            ['room_id', 'user_id'],
        ],
        'room_images' => [
            ['room_id'],
        ],
        'room_facilities' => [
            ['room_id'],
            ['facility_id'],
        ],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->indexDefinitions as $tableName => $indexes) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName, $indexes) {
                foreach ($indexes as $columns) {
                    if (! $this->columnsExist($tableName, $columns)) {
                        continue;
                    }

                    $indexName = $this->makeIndexName($tableName, $columns);

                    if (! $this->indexExists($tableName, $indexName)) {
                        $table->index($columns, $indexName);
                    }
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->indexDefinitions as $tableName => $indexes) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName, $indexes) {
                foreach ($indexes as $columns) {
                    $indexName = $this->makeIndexName($tableName, $columns);

                    if ($this->indexExists($tableName, $indexName)) {
                        $table->dropIndex($indexName);
                    }
                }
            });
        }
    }

    /**
     * Build the index name the same way Laravel does by default.
     */
    private function makeIndexName(string $table, array $columns): string
    {
        return strtolower($table . '_' . implode('_', $columns) . '_index');
    }

    /**
     * Ensure all indexed columns exist on the table.
     */
    private function columnsExist(string $table, array $columns): bool
    {
        foreach ($columns as $column) {
            if (! Schema::hasColumn($table, $column)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check whether an index already exists in the database.
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $connection = Schema::getConnection();
        $database = $connection->getDatabaseName();

        $result = $connection->selectOne(
            'SELECT COUNT(*) AS aggregate
             FROM INFORMATION_SCHEMA.STATISTICS
             WHERE TABLE_SCHEMA = ?
               AND TABLE_NAME = ?
               AND INDEX_NAME = ?',
            [$database, $table, $indexName]
        );

        return ((int) ($result->aggregate ?? 0)) > 0;
    }
};
