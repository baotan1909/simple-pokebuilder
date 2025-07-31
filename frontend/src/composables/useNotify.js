export function useNotify() {
  function notify(message) {
    window.alert(message)
  }

  function confirmAction(message) {
    return window.confirm(message)
  }

  return { notify, confirm: confirmAction }
}