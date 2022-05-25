import { render } from 'preact'
import Context from './context'
import Pages from './pages'

const portal = document.getElementById('appx')
const App = () => (
  <Context>
    <Pages />
  </Context>
)

render(<App />, portal)

