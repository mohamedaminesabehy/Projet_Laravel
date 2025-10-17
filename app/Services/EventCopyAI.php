<?php

namespace App\Services;

use Illuminate\Support\Str;
use Carbon\Carbon;

class EventCopyAI
{
    private array $tones = [
        'en' => [
            'professional' => ['insightful','practical','focused','actionable'],
            'friendly'     => ['fun','welcoming','hands-on','chill'],
            'exciting'     => ['exclusive','can’t-miss','high-energy','next-level'],
        ],
        'fr' => [
            'professionnel'=> ['pertinent','pratique','ciblé','actionnable'],
            'convivial'    => ['ludique','accueillant','pratique','détendu'],
            'dynamique'    => ['exclusif','incontournable','énergique','de haut niveau'],
        ]
    ];

    private array $forms = [
        'en' => ['Summit','Workshop','Bootcamp','Meetup','Conference','Forum','Hackathon','Masterclass','Talk','Session'],
        'fr' => ['Sommet','Atelier','Bootcamp','Meetup','Conférence','Forum','Hackathon','Masterclass','Talk','Session'],
    ];

    private array $openers = [
        'en' => ['Join us for','Discover','Level up with','Dive into','Hands-on session:','From idea to impact:'],
        'fr' => ['Rejoignez-nous pour','Découvrez','Progressez avec','Plongez dans','Atelier pratique :','De l’idée à l’impact :'],
    ];

    private array $ctas = [
        'en' => ['Save your seat','Limited spots—register now','Bring your questions','Reserve your place today'],
        'fr' => ['Réservez votre place','Places limitées—inscrivez-vous','Venez avec vos questions','Inscription dès maintenant'],
    ];

    private array $audiencePhrases = [
        'en' => [
            'students' => 'for students',
            'developers' => 'for developers',
            'managers' => 'for managers',
            'designers' => 'for designers',
            'everyone' => 'open to all',
        ],
        'fr' => [
            'students' => 'pour les étudiants',
            'developers' => 'pour les développeurs',
            'managers' => 'pour les managers',
            'designers' => 'pour les designers',
            'everyone' => 'ouvert à tous',
        ],
    ];

    public function generate(array $input): array
    {
        $lang     = in_array($input['lang'] ?? 'en', ['en','fr']) ? $input['lang'] : 'en';
        $tone     = $this->normalizeTone($input['tone'] ?? 'professional', $lang);
        $audience = $this->normalizeAudience($input['audience'] ?? 'everyone');
        $length   = $input['length'] ?? 'medium';
        $keywords = $this->sanitizeKeywords($input['keywords'] ?? []);

        $context = [
            'start_date' => $this->fmtDate($input['start_date'] ?? null, $lang),
            'end_date'   => $this->fmtDate($input['end_date'] ?? null, $lang),
            'location'   => $this->sanitizeInline($input['location'] ?? null),
        ];

        $title = $this->buildTitle($keywords, $lang, $tone, $audience);
        $variants = array_values(array_unique(array_filter([
            $title,
            $this->buildTitle($keywords, $lang, $tone, $audience, alt:true),
            $this->buildTitle(array_reverse($keywords), $lang, $tone, $audience, alt:true),
        ])));

        $description = $this->buildDescription($keywords, $lang, $tone, $audience, $length, $context);

        return [
            'title' => $title,
            'description' => $description,
            'variants' => $variants,
            'meta' => compact('lang','tone','audience','length','keywords') + $context,
        ];
    }

    private function sanitizeKeywords(array $kw): array
    {
        $clean = [];
        foreach ($kw as $k) {
            $k = trim(Str::of($k)->lower()->squish());
            if ($k !== '' && strlen($k) <= 40) $clean[] = $k;
        }
        $clean = array_slice(array_unique($clean), 0, 6);
        return count($clean) ? $clean : ['event'];
    }

    private function normalizeTone(string $t, string $lang): string
    {
        $map = [
            'en' => ['professional','friendly','exciting'],
            'fr' => ['professionnel','convivial','dynamique'],
        ];
        $t = Str::lower($t);
        return in_array($t, $map[$lang]) ? $t : $map[$lang][0];
    }

    private function normalizeAudience(string $a): string
    {
        $a = Str::lower($a);
        $keys = array_keys($this->audiencePhrases['en']);
        return in_array($a, $keys) ? $a : 'everyone';
    }

    private function pick(array $arr): string { return $arr[array_rand($arr)]; }

    private function titleFromKeywords(array $kw, string $lang): string
    {
        $cap = fn($s)=>Str::title($s);
        if (count($kw) >= 2) {
            $k1 = $cap($kw[0]); $k2 = $cap($kw[1]);
            return "{$k1} & {$k2}";
        }
        return $cap($kw[0]);
    }

    private function buildTitle(array $kw, string $lang, string $tone, string $audience, bool $alt=false): string
    {
        $form = $this->pick($this->forms[$lang]);
        $toneWord = $this->pick($this->tones[$lang][$tone]);
        $main = $this->titleFromKeywords($kw, $lang);

        $patterns = $alt
            ? ["{$main} {$form}", "{$form}: {$main}", "{$form} {$toneWord} — {$main}"]
            : ["{$form} {$toneWord}: {$main}", "{$form} — {$main}", "{$main} — {$form}"];

        // audience hint
        $title = $this->pick($patterns);
        $aud = $this->audiencePhrases[$lang][$audience] ?? null;
        if ($aud && Str::length($title) < 58) $title .= ' · ' . $aud;

        return Str::limit($title, 75, '…');
    }

    private function buildDescription(array $kw, string $lang, string $tone, string $audience, string $length, array $ctx): string
    {
        $opener = $this->pick($this->openers[$lang]);
        $cta    = $this->pick($this->ctas[$lang]);
        $aud    = $this->audiencePhrases[$lang][$audience] ?? ($lang==='fr'?'ouvert à tous':'open to all');

        $topic = Str::title($kw[0]);
        $extra = isset($kw[1]) ? Str::title($kw[1]) : null;

        // contextual bits
        $when = $this->whenPhrase($ctx['start_date'], $ctx['end_date'], $lang);
        $where = $ctx['location'] ? (($lang==='fr'?'à ':'at ').$ctx['location']) : null;

        $sentences = [];
        if ($lang === 'fr') {
            $sentences[] = "{$opener} un {$this->pick($this->forms['fr'])} {$this->pick($this->tones['fr'][$tone])} sur {$topic}" . ($extra ? " et {$extra}" : '') . " {$aud}" . ($when ? " {$when}" : '') . ($where ? " {$where}" : '') . ".";
            $sentences[] = "Au programme : contenu {$this->pick($this->tones['fr'][$tone])}, échanges concrets et exercices rapides pour passer de la théorie à la pratique.";
            if ($length !== 'short') $sentences[] = "Que vous débutiez ou souhaitiez aller plus loin, vous repartirez avec des méthodes applicables dès aujourd’hui.";
            $sentences[] = "{$cta}.";
        } else {
            $sentences[] = "{$opener} a {$this->pick($this->forms['en'])} that’s {$this->pick($this->tones['en'][$tone])} on {$topic}" . ($extra ? " and {$extra}" : '') . " {$aud}" . ($when ? " {$when}" : '') . ($where ? " {$where}" : '') . ".";
            $sentences[] = "Expect {$this->pick($this->tones['en'][$tone])} content, practical takeaways, and quick exercises to move from theory to impact.";
            if ($length !== 'short') $sentences[] = "Whether you’re getting started or leveling up, you’ll leave with tools you can apply immediately.";
            $sentences[] = "{$cta}.";
        }

        if ($length === 'short') $sentences = array_slice($sentences, 0, 2);
        if ($length === 'long')  $sentences[] = $lang==='fr'
            ? "Astuce : venez avec un collègue pour progresser plus vite en binôme."
            : "Tip: bring a friend to pair up and accelerate learning.";

        return implode(' ', $sentences);
    }

    private function fmtDate(?string $dt, string $lang): ?string
    {
        if (!$dt) return null;
        try {
            $c = Carbon::parse($dt);
            return $lang==='fr' ? $c->translatedFormat('d F Y H:i') : $c->format('F j, Y H:i');
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function whenPhrase(?string $start, ?string $end, string $lang): ?string
    {
        if (!$start && !$end) return null;
        if ($start && $end) {
            return $lang==='fr' ? "du {$start} au {$end}" : "from {$start} to {$end}";
        }
        if ($start) return $lang==='fr' ? "le {$start}" : "on {$start}";
        return $lang==='fr' ? "jusqu’au {$end}" : "until {$end}";
    }

    private function sanitizeInline(?string $s): ?string
    {
        if (!$s) return null;
        $s = trim($s);
        $s = preg_replace('/\s+/', ' ', $s);
        return Str::limit($s, 80);
    }
}
