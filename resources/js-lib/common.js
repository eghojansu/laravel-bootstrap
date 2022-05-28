import axios from 'axios'

export const random = (len = 8) => {
  const chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~!@-#$'

  return Array.from(crypto.getRandomValues(new Uint32Array(len))).map(r => chars[r % chars.length]).join('')
}
export const request = (() => {
  const req = axios.create({
    withCredentials: true,
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
  })
  req.interceptors.response.use(
    response => {
      const { success = true, message, data, errors } = response.data || {}

      return {
        success,
        data,
        errors,
        response,
        message: message || response.statusText,
      }
    },
    error => {
      const { success = false, message, data, errors } = error.response.data || {}

      return Promise.resolve({
        success,
        data,
        errors,
        error,
        message: message || error.response.statusText,
      })
    },
  )

  return req
})()
