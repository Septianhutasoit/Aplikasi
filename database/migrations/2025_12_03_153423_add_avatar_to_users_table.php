    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::table('users', function (Blueprint $table) {
                // Tambahkan kolom address jika belum ada
                if (!Schema::hasColumn('users', 'address')) {
                    $table->text('address')->nullable()->after('email');
                }

                // Tambahkan kolom avatar jika belum ada (jaga-jaga)
                if (!Schema::hasColumn('users', 'avatar')) {
                    $table->string('avatar')->nullable()->after('email');
                }
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'address')) {
                    $table->dropColumn('address');
                }
                if (Schema::hasColumn('users', 'avatar')) {
                    $table->dropColumn('avatar');
                }
            });
        }
    };
