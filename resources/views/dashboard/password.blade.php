<x-dashboard title="Password">
  <x-form-container>
    <x-form-control
      :width="6"
      :break="true"
      :generator="true"
      name="new_password"
      type="password"
      required />
    <x-form-control
      :width="6"
      :break="true"
      name="password"
      type="password"
      hint="Enter current password for any changes"
      required />
  </x-form-container>
</x-dashboard>
