<x-dashboard title="System Preference">
  <x-form-container>
    @foreach ($prefs as $pref)
      <x-form-control
        :width="6"
        :break="true"
        :name="$pref->name"
        :label="$pref->content['desc']"
        :value="$pref->content['value']"
        required />
    @endforeach
  </x-form-container>
</x-dashboard>
