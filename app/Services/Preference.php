<?php

namespace App\Services;

use App\Models\Cspref;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Inspiring;

/**
 * @property int $attMax
 * @property int $attTo
 * @property string $dtFmt
 * @property string $dtimeFmt
 * @property string $tsFmt
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
        'dtFmt' => array(
            'value' => 'd/m/Y',
            'type' => 'string',
            'desc' => 'Date format',
        ),
        'dtimeFmt' => array(
            'value' => 'd/m/Y H:i',
            'type' => 'string',
            'desc' => 'Date time format',
        ),
        'tsFmt' => array(
            'value' => 'd/m/Y H:i:s',
            'type' => 'string',
            'desc' => 'Timestamp format',
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

    public function update(array $data): void
    {
        array_walk($data, function($value, $name) {
            if ($pref = $this->get($name)) {
                $content = $pref->content;
                $content['value'] = $value;

                $pref->update(compact('content'));
            }
        });
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
