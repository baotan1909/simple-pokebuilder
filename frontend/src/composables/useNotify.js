export function useNotify() {
    async function notify(message) {
      if (!('Notification' in window)) {
        console.warn('Browser does not support notifications')
        return
      }
  
      const permission = Notification.permission
  
      if (permission === 'granted') {
        new Notification(message)
        return
      }
  
      if (permission === 'denied') {
        console.warn('Notification permission denied')
        return
      }
  
      try {
        const result = await Notification.requestPermission()
        if (result === 'granted') {
          new Notification(message)
        }
      } catch (err) {
        console.warn('Notification permission request failed:', err)
      }
    }
  
    return { notify }
  }
  