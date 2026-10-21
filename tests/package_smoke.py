#!/usr/bin/env python3
"""Fast package checks that require only the Python standard library."""

from __future__ import annotations

import re
import sqlite3
import unittest
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
DEMO_SLUGS = ("sepatu", "iphone", "toko-online", "pos-kasir", "katalog-produk")


class DemoPackageSmokeTest(unittest.TestCase):
    def test_standalone_demo_hub_links_every_demo(self) -> None:
        hub = ROOT / "public" / "demo" / "index.html"
        self.assertTrue(hub.is_file(), "public/demo/index.html must exist")
        html = hub.read_text(encoding="utf-8")
        for slug in DEMO_SLUGS:
            self.assertIn(f'./{slug}/index.html', html)
            self.assertTrue((hub.parent / slug / "index.html").is_file())

    def test_unified_visual_assets_are_present_and_legacy_layers_are_removed(self) -> None:
        public_layout = (ROOT / "resources" / "views" / "layouts" / "app.blade.php").read_text(encoding="utf-8")
        admin_layout = (ROOT / "resources" / "views" / "admin" / "layouts" / "app.blade.php").read_text(encoding="utf-8")
        login = (ROOT / "resources" / "views" / "auth" / "login.blade.php").read_text(encoding="utf-8")

        self.assertIn("assets/css/site.css", public_layout)
        self.assertIn("assets/css/admin.css", admin_layout)
        self.assertIn("assets/css/admin.css", login)
        self.assertTrue((ROOT / "public" / "images" / "logo-mark.svg").is_file())

        expected_showcases = (
            "demo-toko-online.webp",
            "demo-pos-kasir.webp",
            "demo-katalog.webp",
            "demo-sepatu.webp",
            "demo-iphone.webp",
        )
        for filename in expected_showcases:
            asset = ROOT / "public" / "images" / "showcase" / filename
            self.assertTrue(asset.is_file(), f"showcase asset missing: {filename}")
            self.assertGreater(asset.stat().st_size, 1_000)

        legacy_css = (
            "app.css", "theme.css", "responsive.css", "visual-refresh.css",
            "refactor-modern.css", "admin-visual-refresh.css",
        )
        for filename in legacy_css:
            self.assertFalse((ROOT / "public" / "assets" / "css" / filename).exists())

    def test_default_environment_uses_portable_sqlite_database(self) -> None:
        env = (ROOT / ".env").read_text(encoding="utf-8")
        self.assertRegex(env, r"(?m)^DB_CONNECTION=sqlite$")
        database = ROOT / "database" / "database.sqlite"
        self.assertTrue(database.is_file(), "database/database.sqlite must be shipped")
        with sqlite3.connect(database) as connection:
            product_count = connection.execute("SELECT COUNT(*) FROM products").fetchone()[0]
            product_image_count = connection.execute("SELECT COUNT(*) FROM products WHERE image IS NOT NULL AND image != ''").fetchone()[0]
            portfolio_image_count = connection.execute("SELECT COUNT(*) FROM portfolios WHERE image IS NOT NULL AND image != ''").fetchone()[0]
            self.assertGreaterEqual(product_count, len(DEMO_SLUGS))
            self.assertEqual(product_count, product_image_count, "every seeded product should have a visual preview")
            self.assertGreaterEqual(portfolio_image_count, 2, "seeded portfolio items should have visual previews")

    def test_sitemap_is_generated_dynamically(self) -> None:
        self.assertFalse((ROOT / "public" / "sitemap.xml").exists(), "static sitemap must not shadow the Laravel route")
        controller = (ROOT / "app" / "Http" / "Controllers" / "SitemapController.php").read_text(encoding="utf-8")
        view = ROOT / "resources" / "views" / "sitemap.blade.php"
        self.assertIn("PublicContentFallbacks", controller)
        self.assertIn("response()", controller)
        self.assertTrue(view.is_file(), "dynamic sitemap view must exist")

    def test_runtime_artifacts_are_not_shipped(self) -> None:
        forbidden = [
            ROOT / "storage" / "logs" / "laravel.log",
            ROOT / "bootstrap" / "cache" / "packages.php",
            ROOT / "bootstrap" / "cache" / "services.php",
        ]
        for path in forbidden:
            self.assertFalse(path.exists(), f"runtime artifact must be removed: {path.relative_to(ROOT)}")

        generated_dirs = [
            ROOT / "storage" / "framework" / "cache" / "data",
            ROOT / "storage" / "framework" / "sessions",
            ROOT / "storage" / "framework" / "views",
        ]
        for directory in generated_dirs:
            leftovers = [p for p in directory.rglob("*") if p.is_file() and p.name not in {".gitignore", ".gitkeep"}]
            self.assertEqual([], leftovers, f"generated files remain under {directory.relative_to(ROOT)}")

    def test_legacy_demo_bundles_are_removed(self) -> None:
        legacy_paths = [
            ROOT / "public" / "demo" / "iphone" / "build",
            ROOT / "public" / "demo" / "iphone" / "images",
            ROOT / "public" / "demo" / "sepatu" / "build",
        ]
        for path in legacy_paths:
            self.assertFalse(path.exists(), f"unused legacy bundle must be removed: {path.relative_to(ROOT)}")

    def test_phone_pattern_is_valid_for_modern_browsers(self) -> None:
        html = (ROOT / "public" / "demo" / "toko-online" / "index.html").read_text(encoding="utf-8")
        match = re.search(r'name="phone"[^>]+pattern="([^"]+)"', html)
        self.assertIsNotNone(match, "phone field must keep explicit client-side validation")
        self.assertEqual(r"(?:[0-9+]|\(|\)|-| ){8,18}", match.group(1))

    def test_all_demo_pages_are_self_contained_and_have_expected_controls(self) -> None:
        for slug in DEMO_SLUGS:
            html_path = ROOT / "public" / "demo" / slug / "index.html"
            html = html_path.read_text(encoding="utf-8")
            self.assertRegex(html, r"(?i)<!doctype html>")
            self.assertIn("<script>", html)
            self.assertNotRegex(html, r'<script[^>]+src=', f"{slug} should not depend on a JS bundle")
            self.assertNotRegex(html, r'<link[^>]+href=["\'](?:build|/build)', f"{slug} should not depend on a CSS bundle")
            self.assertNotRegex(html, r'https?://', f"{slug} should work fully offline")
            self.assertRegex(html, r'id=["\'](?:products|menu|katalog|view-kasir)["\']')


if __name__ == "__main__":
    unittest.main(verbosity=2)
