#!/usr/bin/env python3
"""Static PRD regression guard. Full Laravel UAT requires PHP database extensions."""
from pathlib import Path
import unittest

ROOT = Path(__file__).resolve().parents[1]

def read(path):
    return (ROOT / path).read_text(encoding="utf-8")

class PrdRevisionSmoke(unittest.TestCase):
    def test_product_context_and_snapshot(self):
        self.assertIn("['produk' => $product->slug]", read('resources/views/products/detail.blade.php'))
        controller = read('app/Http/Controllers/ConsultationController.php')
        for item in ['product_id', 'product_name_snapshot', 'Product::findOrFail', 'reference_code']:
            self.assertIn(item, controller)

    def test_client_quota_and_role_security(self):
        register = read('app/Http/Controllers/Auth/RegisterController.php')
        self.assertIn("where('used', '<', 10)->increment('used')", register)
        self.assertIn('DB::transaction', register)
        self.assertIn("'role' => 'client'", register)
        self.assertIn('abort_unless($consultation->user_id === $request->user()->id, 404)', read('app/Http/Controllers/Client/AccountController.php'))
        self.assertIn('ClientMiddleware::class', read('bootstrap/app.php'))
        self.assertIn("['admin','editor']", read('app/Http/Middleware/AdminMiddleware.php'))

    def test_notification_and_private_notes(self):
        admin = read('app/Http/Controllers/Admin/ConsultationController.php')
        self.assertIn('ConsultationNotifications::forOwner', admin)
        self.assertIn('statusLogs()->create', admin)
        self.assertIn('admin_notes', read('resources/views/admin/consultations/show.blade.php'))
        self.assertNotIn('admin_notes', read('resources/views/client/consultation-detail.blade.php'))

    def test_catalog_demo_and_csv_still_exist(self):
        routes = read('routes/web.php')
        self.assertIn("Route::get('/demo/{demo}'", routes)
        self.assertIn("Route::get('/produk'", routes)
        self.assertIn('consultations-export', read('routes/admin.php'))
        self.assertIn('price_is_starting_at', read('resources/views/admin/products/partials/form.blade.php'))
        self.assertIn('Harga menyesuaikan kebutuhan', read('app/Support/ProductPricing.php'))

if __name__ == '__main__':
    unittest.main()
