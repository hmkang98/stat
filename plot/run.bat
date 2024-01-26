del c:\temp\mykeystore c:\temp\userkeystore
del *.jar *.cer *.class
javac Sample.java
del mykeystore
del *.jar
jar cvf Sample.jar *.class *.gif
keytool -genkey -alias SignedSample -keystore mykeystore -keypass kangheemo -dname "cn=Hallym Univ." -storepass kangheemo
jarsigner -keystore mykeystore -storepass kangheemo -signedjar SignedSample.jar Sample.jar SignedSample
keytool -export -keystore mykeystore -storepass kangheemo -alias SignedSample -file SignedSample.cer
keytool -import -alias SignedSample -file SignedSample.cer -keystore c:/temp/userkeystore -storepass ReceiverSample -keypass applet
