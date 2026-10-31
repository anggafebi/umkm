#!/usr/bin/env python3
"""Pemeriksaan regresi statis PRD v1.2; bukan pengganti UAT database/browser."""
from pathlib import Path
import unittest
R = Path(__file__).resolve().parents[1]
def source(name): return (R/name).read_text(encoding='utf-8')
class PrdV12Smoke(unittest.TestCase):
    def test_about_official_copy_and_no_fake_metrics(self):
        v=source('resources/views/about/index.blade.php')
        for marker in ['CV. Aditif Tekno Multisolusi','Menjadi mitra system integrator terpercaya','Mendorong efisiensi, modernisasi','Accountability &amp; Integrity','Teamwork &amp; Trust','Mastery &amp; Improvement','Tim di balik layanan Aditech']:
            self.assertIn(marker,v)
        self.assertNotIn('50+',v)
        self.assertNotIn('98%',v)
    def test_process_six_steps(self):
        v=source('resources/views/home/index.blade.php')
        labels=['Konsultasi','Analisis','Proposal','Development','Testing','Launching']
        actual=[v.index(f"['0{i}', '{label}'") for i,label in enumerate(labels,1)]
        self.assertEqual(actual,sorted(actual))
        self.assertNotIn("['01', 'Pemetaan'",v)
    def test_instagram_and_no_fake_linkedin(self):
        for file in ['resources/views/layouts/footer.blade.php','resources/views/contact/index.blade.php']:
            s=source(file)
            self.assertIn('https://www.instagram.com/aditech.id/',s)
            self.assertIn('noopener noreferrer',s)
            self.assertNotIn('linkedin.com',s)
    def test_two_way_reply_ownership_and_close(self):
        routes=source('routes/web.php')
        self.assertIn("'client'",routes)
        self.assertIn("name('consultations.reply')",routes)
        controller=source('app/Http/Controllers/Client/AccountController.php')
        for marker in ['abort_unless($consultation->user_id === $request->user()->id, 404)',"$locked->status === 'closed'", "'sender_role' => 'client'",'lockForUpdate()', 'ConsultationNotifications::forStaffReply', 'submission_token']:
            self.assertIn(marker,controller)
        self.assertNotIn('admin_notes',source('resources/views/client/consultation-detail.blade.php'))
        self.assertIn('Percakapan Konsultasi',source('resources/views/client/consultation-detail.blade.php'))
    def test_admin_stays_private_and_csv(self):
        admin=source('app/Http/Controllers/Admin/ConsultationController.php')
        for marker in ['consultation_client_reply','lockForUpdate()',"$locked->status === 'closed'",'statusLogs()->create']:
            self.assertIn(marker,admin)
        self.assertIn('consultations-export',source('routes/admin.php'))
        self.assertIn('Catatan Admin (privat)',source('resources/views/admin/consultations/show.blade.php'))
    def test_other_custom_input_is_server_validated(self):
        form=source('resources/views/consultation/index.blade.php')
        controller=source('app/Http/Controllers/ConsultationController.php')
        for marker in ['Lainnya (ketik sendiri)','service_interest_other','customServiceField']:
            self.assertIn(marker,form)
        self.assertIn('required_if:service_interest,Lainnya',controller)
        self.assertIn("'Lainnya: '.trim($data['service_interest_other'])",controller)
    def test_migration_non_destructive(self):
        migration=source('database/migrations/2026_10_31_000002_add_tickets_reply_tokens.php')
        self.assertIn("Schema::table('consultation_messages'", migration)
        self.assertNotIn('dropIfExists',migration)
        self.assertIn('submission_token',migration)
        self.assertIn('consultation_messages_timeline_idx',migration)
if __name__=='__main__': unittest.main(verbosity=2)
