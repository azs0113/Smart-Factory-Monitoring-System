import socket
import mysql.connector  

db =  mysql.connector.connect(host="", user="", password="", db="")
					 
#create a Cursor object.  
cur = db.cursor()   
  
# Write SQL statement here  
  					 

s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
# print socket.getdefaulttimeout()
# socket.setdefaulttimeout(60)
s.bind(('192.168.1.110', 10004))
#s.listen(1)


#conn, addr = s.accept()
#print 'Connection address: ', addr

while 1:

	data, address = s.recvfrom(1024)
	cur.execute("UPDATE sensor_table SET sensor_value = %s where sensor_address= %s;", (data, address[0]))
	db.commit()
	print "received data:", data
	#s.sendto(data, address)
	
	
