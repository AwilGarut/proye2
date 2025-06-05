<?

// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

use function Laravel\Prompts\alert;

Route::post('/midtrans/callback', [TransactionController::class, 'handleCallback']);

Route::get('/test', function() {

      return response()->json([
        'status' => 'success',
        'message' => 'Transaction inserted successfully'
    ]);
});

