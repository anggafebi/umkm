<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Setting;
class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['general','site_name','Aditech Multisolusi','text'],
            ['general','tagline','Website dan sistem bisnis untuk UMKM','text'],
            ['general','email','info@aditech.id','text'],
            ['general','phone','087848127894','text'],
            ['general','location','Indonesia','text'],
            ['general','logo_path','images/logo.png','text'],
            ['general','about_title','Partner digital untuk bisnis yang ingin bergerak lebih terstruktur.','text'],
            ['general','about_description','Kami membantu UMKM membangun kehadiran digital dan sistem bisnis yang mudah digunakan, terukur, dan siap dikembangkan.','textarea'],
            ['home','hero_image','images/hero/hero-mockup.png','text'],
            ['home','hero_badge','Partner Digital untuk UMKM','text'],
            ['home','hero_title','Website dan sistem digital yang membuat bisnis lebih siap tumbuh.','text'],
            ['home','hero_subtitle','Kami membantu UMKM membangun website, katalog, dan sistem operasional yang jelas, cepat, dan mudah dikelola.','textarea'],
            ['home','stat_projects','50+','text'], ['home','stat_satisfaction','98%','text'], ['home','stat_support','Dukungan cepat','text'],
            ['home','stat_mobile','Utamakan seluler','text'], ['home','stat_mobile_label','Responsif di semua perangkat','text'],
            ['home','client_names','','textarea'],
            ['home','why_title','Solusi digital yang dibangun untuk kebutuhan bisnis nyata.','text'],
            ['home','why_description','Bukan sekadar tampilan, setiap solusi dirancang agar mudah dikelola, cepat digunakan, dan siap dikembangkan.','textarea'],
            ['home','services_title','Solusi digital untuk kebutuhan bisnis yang nyata.','text'],
            ['home','portfolio_title','Pekerjaan yang dirancang untuk memberi dampak.','text'],
            ['home','pricing_title','Pilih titik awal yang sesuai dengan kebutuhan bisnis.','text'],
            ['home','process_title','Terarah dari konsultasi hingga peluncuran.','text'],
            ['home','process_description','Setiap tahap memiliki tujuan yang jelas agar proses tetap efisien, transparan, dan sesuai kebutuhan bisnis.','textarea'],
            ['home','testimonial_title','Apa yang dirasakan klien setelah go digital.','text'],
            ['home','blog_title','Artikel untuk membantu bisnis mengambil keputusan digital.','text'],
            ['home','faq_title','Pertanyaan yang sering diajukan.','text'],
            ['home','faq_description','Jawaban ringkas untuk hal yang paling sering ditanyakan sebelum proyek dimulai.','textarea'],
            ['home','cta_title','Bangun fondasi digital yang lebih profesional untuk bisnis Anda.','text'],
            ['home','cta_description','Ceritakan target dan kendala bisnis Anda. Kami bantu memetakan solusi yang relevan dan realistis.','textarea'],
            ['social','instagram','','text'], ['social','linkedin','','text'], ['social','facebook','','text'],
            ['seo','meta_title','Aditech Multisolusi | Solusi Digital UMKM','text'],
            ['seo','meta_description','Jasa website, katalog digital, sistem bisnis, dan solusi digital untuk membantu UMKM berkembang.','textarea'],
            ['seo','meta_keywords','website UMKM, sistem informasi, digitalisasi bisnis, Laravel','text'],
            ['seo','og_image','images/showcase/demo-pos-kasir.webp','text'],
            ['seo','google_analytics_id','','text'],
            ['theme','default_theme','system','select'], ['theme','dark_mode_enabled','1','boolean'],
            ['theme','primary_color','#315ff4','color'],
        ];
        foreach ($items as [$group,$key,$value,$type]) Setting::firstOrCreate(['key'=>$key], compact('group','value','type'));
    }
}
