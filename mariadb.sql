/*M!999999\- enable the sandbox mode */
-- MariaDB dump 10.19  Distrib 10.5.26-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: config_generator
-- ------------------------------------------------------
-- Server version       10.5.26-MariaDB-0+deb11u2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `commands`
--

DROP TABLE IF EXISTS `commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor` varchar(50) NOT NULL,
  `comment_tag` varchar(300) NOT NULL,
  `top_comment1` varchar(300) NOT NULL,
  `top_comment2` varchar(300) NOT NULL,
  `top_comment3` varchar(300) NOT NULL,
  `hostname` varchar(300) NOT NULL,
  `ip_stack` varchar(300) NOT NULL,
  `ip` varchar(300) NOT NULL,
  `routing_disabled` varchar(300) NOT NULL,
  `routing_enabled` varchar(300) NOT NULL,
  `defaultgateway_routing_d` varchar(300) NOT NULL,
  `defaultgateway_routing_e` varchar(300) NOT NULL,
  `stp_mode_rstp` varchar(300) NOT NULL,
  `stp_mode_stp` varchar(300) NOT NULL,
  `stp_message` varchar(300) NOT NULL,
  `stp_priority` varchar(300) NOT NULL,
  `v_name` varchar(300) NOT NULL,
  `v_redundency_enable` varchar(300) NOT NULL,
  `v_prefix_mask` varchar(300) NOT NULL,
  `v_ip` varchar(300) NOT NULL,
  `v_redundency_message` varchar(300) NOT NULL,
  `v_redundency_ip` varchar(500) NOT NULL,
  `v_redundency_priorety` varchar(300) NOT NULL,
  `v_redundency_preemption` varchar(300) NOT NULL,
  `p_auto_negotiate_disable` varchar(300) NOT NULL,
  `p_vlan_separator` varchar(300) NOT NULL,
  `p_global` varchar(300) NOT NULL,
  `p_name` varchar(300) NOT NULL,
  `p_desc` varchar(300) NOT NULL,
  `p_speed` varchar(300) NOT NULL,
  `p_duplex` varchar(300) NOT NULL,
  `p_tag` varchar(300) NOT NULL,
  `p_vlan_trunk` varchar(300) NOT NULL,
  `p_native_vlan` varchar(300) NOT NULL,
  `p_vlan_access` varchar(300) NOT NULL,
  `p_stp_mode_rstp` varchar(300) NOT NULL,
  `p_stp_mode_stp` varchar(300) NOT NULL,
  `p_global_exit` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commands`
--

LOCK TABLES `commands` WRITE;
/*!40000 ALTER TABLE `commands` DISABLE KEYS */;
INSERT INTO `commands` VALUES (1,'cisco_ios','!','$top_comment1','$top_comment2','$top_comment3','hostname $hostname','interface vlan $mgmt_vlan<br>&nbsp; ip address $ip $subnetmask<br>&nbsp; no shutdown','interface vlan $mgmt_vlan<br>&nbsp; ip address $ip $subnetmask<br>&nbsp; no shutdown','no ip routing','ip routing','ip default-gateway $defaultgateway','ip route 0.0.0.0 0.0.0.0 $defaultgateway','spanning-tree mode rapid-pvst','spanning-tree mode pvst','','spanning-tree vlan 1-4094 priority $stp_Priority','vlan $v_num[$loop]<br>&nbsp;name $v_name[$loop]','','','int vlan $v_num[$loop]<br>&nbsp;ip address $v_ip[$loop] $v_mask[$loop]<br>&nbsp;no shutdown','','&nbsp;standby $v_redundency_group[$loop2] ip $v_redundency_ip[$loop2]','&nbsp;standby $v_redundency_group[$loop2] priority $v_redundency_priorety[$loop2]','&nbsp;standby $v_redundency_group[$loop2] preempt','',',','','int $p_name[$loop]','&nbsp decription $p_desc[$loop]','&nbsp speed $p_speed[$loop]','&nbsp duplex $p_duplex[$loop]','&nbsp switchport trunk encapsulation dot1q<br>&nbsp switchport mode trunk','&nbsp  switchport trunk allowed vlan $p_vlan[$loop]','&nbsp  switchport trunk native vlan $p_native_vlan[$loop]','&nbsp switchport mode access <br>&nbsp  switchport access vlan $p_vlan[$loop]','&nbsp spanning-tree portfast','&nbsp spanning-tree portfast','end'),(2,'juniper_junos','#','$top_comment1','$top_comment2','$top_comment3','set system host-name $hostname','set interfaces vme $juniper_mgmt_int_name unit 0 family inet $ip/$subnetmask','set interfaces me $juniper_mgmt_int_name unit 0 family inet $ip/$subnetmask','<font color=red># No command for Disabling routing, you can use \'firewall filter\' to do that</font>','','set routing-options static route 0.0.0.0/0 next-hop $defaultgateway','set routing-options static route 0.0.0.0/0 next-hop $defaultgateway','set protocols rstp','set protocols stp','','set protocols $stp_mode bridge-priority \".(round($stp_Priority / 1024)).\"k','set vlans $v_name[$loop] vlan-id $v_num[$loop]','','yes','set vlans $v_name[$loop] l3-interface vlan.$v_num[$loop]<br>set interfaces vlan unit $v_num[$loop] family inet address $v_ip[$loop]/$prefix_mask','<font color=red># \'accept-data\' is used to allow ping to the VRRP IP address</font>','set interfaces vlan unit $v_num[$loop] family inet address $v_ip[$loop]/$prefix_mask vrrp-group $v_redundency_group[$loop2]<br>set interfaces vlan unit $v_num[$loop] family inet address $v_ip[$loop]/$prefix_mask virtual-address $v_redundency_ip[$loop2]<br>set interfaces vlan unit $v_num[$loop] family inet address $v_ip[$loop]/$prefix_mask accept-data','set interfaces vlan unit $v_num[$loop] family inet address $v_ip[$loop]/$prefix_mask priority $v_redundency_priorety[$loop2]','set interfaces vlan unit $v_num[$loop] family inet address $v_ip[$loop]/$prefix_mask preempt','set interfaces $p_name[$loop] ether-options no-auto-negotiation',' ','','','set interfaces $p_name[$loop] description $p_desc[$loop]','set interfaces $p_name[$loop] ether-options speed $p_speed[$loop]m','et interfaces $p_name[$loop] ether-options link-mode $p_duplex[$loop]-duplex','set interfaces $p_name[$loop] unit 0 family ethernet-switching port-mode trunk','set interfaces $p_name[$loop] unit 0 family ethernet-switching vlan members [$p_vlan[$loop]]','set interfaces $p_name[$loop] unit 0 family ethernet-switching native-vlan-id $p_native_vlan[$loop]','set interfaces $p_name[$loop] unit 0 family ethernet-switching vlan members [$p_vlan[$loop]]','set protocols $stp_mode interface $p_name[$loop] edge','set protocols $stp_mode interface $p_name[$loop] edge',''),(3,'nortel','!','$top_comment1','$top_comment2','$top_comment3','snmp-server name \\\"$hostname\\\"<br>vlan configcontrol autopvid<br>vlan configcontrol automatic<br>spanning-tree port-mode auto<br>vlan mgmt $mgmt_vlan','ip address stack $ip','ip address unit $ip','no ip routing','ip routing','ip default-gateway $defaultgateway','ip route 0.0.0.0 0.0.0.0 $defaultgateway','spanning-tree mode rstp','spanning-tree mode stpg','<font color=red>! Restart is needed to change stp mode</font>','spanning-tree priority \". (dechex($stp_Priority)) .\"','vlan create $v_num[$loop] name \\\"$v_name[$loop]\\\" type port','router vrrp enable<br>router vrrp<br>ping-virtual-address enable','','int vlan $v_num[$loop]<br>&nbsp;ip address $v_ip[$loop] $v_mask[$loop]','<font color=red>! VRRP is supported only in 55xx from the small switches (for now), but license is required !!<br>! \'backup-master\' will cause VRRP to work as Active/Active</font>','&nbsp;ip vrrp address $v_redundency_group[$loop2] $v_redundency_ip[$loop2]<br>&nbsp;ip vrrp $v_redundency_group[$loop2] enable<br>&nbsp;ip vrrp $v_redundency_group[$loop2] backup-master enable','&nbsp;ip vrrp $v_redundency_group[$loop2] priority $v_redundency_priorety[$loop2]','&nbsp;ip vrrp $v_redundency_group[$loop2] action preempt','',',','interface FastEthernet ALL','','&nbsp name port $p_name[$loop] \\\"$p_desc[$loop]\\\"','&nbsp speed port $p_name[$loop] $p_speed[$loop]','&nbsp duplex port $p_name[$loop] $p_duplex[$loop]','vlan ports $p_name[$loop] tagging tagAll','vlan members add $vlan $p_name[$loop]','vlan ports $p_name[$loop] pvid $p_native_vlan[$loop]','vlan members add $vlan $p_name[$loop]','&nbsp spanning-tree rstp port $p_name[$loop] edge-port','&nbsp spanning-tree port $p_name[$loop] learning fast','exit');
/*!40000 ALTER TABLE `commands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab`
--

DROP TABLE IF EXISTS `lab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(20) NOT NULL,
  `version` varchar(20) NOT NULL,
  `device` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(10) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `port` int(11) NOT NULL,
  `config_reset` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab`
--

LOCK TABLES `lab` WRITE;
/*!40000 ALTER TABLE `lab` DISABLE KEYS */;
INSERT INTO `lab` VALUES (1,'Cisco','5.2(1)','nexus1000v','nexus1000v-1','admin','19920','10.0.0.1',33001,24,'Cluster of 2 N1Kv VSM <br/>+ 1 VEM (ESXi server) <br/>+ SVS connection to vCenter appliance'),(101,'Radware','27.0.0.0','alteon','alteon','admin','84786','10.0.0.101',33101,24,''),(51,'Linux','6.0.6','debian64','debian64','lab','16044','10.0.0.51',33051,24,'debian 64 bit'),(21,'Juniper','10.4R1.9','juniper-router','juniper1','junos','Jnpr33944','10.0.0.21',33022,24,'M router'),(22,'Juniper','10.4R1.9','juniper-router','juniper2','junos','Jnpr68342','10.0.0.22',33023,24,'M router'),(11,'Cisco','12.4(25d)','7200','cisco-r1','cisco','79832','10.0.0.11',33011,24,'Cisco 7200 router'),(2,'Cisco','4.2(1)','nexus1000v','nexus1000v-3','admin','26414','10.0.0.3',33002,24,'Standalone VSM (No VEM / SVS)'),(13,'Cisco','12.4(25d)','3640','cisco-r3','cisco','','10.0.0.13',0,24,'Cisco 3600 router (with switch module)'),(12,'Cisco','12.4(25d)','7200','cisco-r2','cisco','','10.0.0.12',33012,24,'Cisco 7200 router'),(14,'Cisco','12.4(25d)','3640','cisco-r4','cisco','','10.0.0.14',0,24,'Cisco 3600 router (with switch module)'),(4,'VMware','5.1','vCenter appliance','vc-appliance','','','10.0.0.8',0,24,'VMware vCenter 5.1 appliance'),(15,'Cisco','12.4(25d)','7200','cisco-r5','cisco','','10.0.0.15',0,24,'Cisco 7200 router'),(16,'Cisco','12.4(25d)','7200','cisco-r6','cisco','','10.0.0.16',0,24,'Cisco 7200 router'),(3,'VMware','5.1','esxi 5.1 server','esxi-5.1','','','10.0.0.5',0,24,'VMware ESXi 5.1 server'),(23,'Juniper','10.4R1.9','juniper-router','juniper3','junos','','10.0.0.23',0,0,'M router'),(31,'Cisco','12.4(25g)','7200','cisco-r31','cisco','','10.0.0.31',33031,24,'Cisco 7200 router'),(32,'Cisco','12.4(25g)','7200','cisco-r32','cisco','','10.0.0.32',33032,24,'Cisco 7200 router'),(33,'Cisco','12.4(25g)','7200','cisco-r33','cisco','','10.0.0.33',33033,24,'Cisco 7200 router'),(34,'Cisco','12.4(25g)','7200','cisco-r34','cisco','','10.0.0.34',33034,24,'Cisco 7200 router'),(125,'Cisco','3.13','CSR1000v','CSR1000v','admin','0','10.0.0.9',0,24,'Cisco virtual router');
/*!40000 ALTER TABLE `lab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workers`
--

DROP TABLE IF EXISTS `workers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `privilege` int(11) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workers`
--

LOCK TABLES `workers` WRITE;
/*!40000 ALTER TABLE `workers` DISABLE KEYS */;
INSERT INTO `workers` VALUES (1,'user','user',15);
/*!40000 ALTER TABLE `workers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-01 18:54:44
