import redis
import sys

r = redis.Redis()
user = sys.argv[1]

def setUserSession(user):
    r.set(f"{user}-count", 1)
    r.set(f"{user}-time", "is not expired")
    r.expire(f"{user}-time", 600)
    r.set(user, 1)

def getUserSession(user):
    return {"timeout" : r.get(f"{user}-time"), "count" : r.get(f"{user}-count")}

def incrementUserSession(user):
    r.incr(f"{user}-count")

userSession = getUserSession(user)
sessionTimeout = userSession["timeout"]
sessionCount = int(userSession["count"])

if sessionTimeout == None:
       setUserSession(user)
       print(1)
else:
    if sessionCount < 10:
        incrementUserSession(user)
        print(sessionCount + 1)
    else:
        print(f"RateLimit Connection. Timeout Restart : {r.ttl(user+'-time') // 60}m.")
        
sys.exit(8)