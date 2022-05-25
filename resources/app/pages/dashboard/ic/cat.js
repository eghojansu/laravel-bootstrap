import CrudCompact from '../../../components/crud-compact'

export default () => {
  return (
    <CrudCompact
      pkey="catid"
      title="Item Categories"
      resource="/api/ic/cat"
      gridBase={{
        width: 4,
        wrap: true,
      }}
      grid={{
        catid: {
          label: 'ID',
          width: 5,
          input: {
            type: 'cursor',
            required: true,
            minlength: 3,
            maxlength: 8,
          }
        },
        name: {
          input: {
            required: true,
            minlength: 3,
            maxlength: 32,
          }
        },
      }} />
  )
}
