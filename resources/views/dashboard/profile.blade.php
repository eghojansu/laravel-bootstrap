<x-dashboard title="Profile">
  <x-form-container>
    <x-form-control
      :width="6"
      :value="$user['name']"
      required />
    <x-form-control
      :width="6"
      :value="$user['email']"
      name="email"
      type="email" />
    <x-form-control
      :width="6"
      :break="true"
      :plain="true"
      :value="cts($user['joindt'])"
      name="join_date" />
    <x-form-control
      :width="6"
      :break="true"
      name="password"
      type="password"
      hint="Enter current password for any changes"
      required />
  </x-form-container>
</x-dashboard>
