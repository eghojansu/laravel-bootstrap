<?php

namespace App\Service;

use App\Models\Cspref;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Inspiring;

/**
 * @property int $attMax
 * @property int $attTo
 */
class Preference
{
    private $defaults = array(
        'attMax' => array(
            'value' => 3,
            'type' => 'int',
            'desc' => 'Maximum attempt count',
        ),
        'attTo' => array(
            'value' => 5,
            'type' => 'int',
            'desc' => 'Next minutes after account locked',
        ),
    );

    /** @var Collection<string, Cspref> */
    public $repo;

    public function __construct()
    {
        $this->loadPreferences();
    }

    public function __get($name)
    {
        $pref = $this->get($name);

        if (!$pref) {
            throw new \LogicException(sprintf('Preference not exists: %s', $name));
        }

        return $pref->value;
    }

    public function getQuote(): array
    {
        $source = Inspiring::quote();
        $byDash = strrpos($source, '-');
        $text = trim(substr($source, 0, $byDash - 1));
        $by = trim(substr($source, $byDash + 1));

        return compact('text', 'by');
    }

    private function get(string $name): Cspref|null
    {
        /** @var Cspref|null */
        $pref = $this->repo->first(static fn (Cspref $pref) => $pref->name === $name);

        return $pref;
    }

    private function loadPreferences(): void
    {
        $this->repo = Cspref::all();

        array_walk($this->defaults, function (array $content, string $name) {
            if ($this->get($name)) {
                return;
            }

            $this->repo->add(Cspref::firstOrCreate(
                compact('name'),
                compact('content'),
            ));
        });
    }
}
