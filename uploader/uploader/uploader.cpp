#include "stdafx.h"
#include <stdlib.h>
#include <iostream>

/*
Include directly the different
headers from cppconn/ and mysql_driver.h + mysql_util.h
(and mysql_connection.h). This will reduce your build time!
*/
#include "mysql_connection.h"

#include <cppconn/driver.h>
#include <cppconn/exception.h>
#include <cppconn/resultset.h>
#include <cppconn/statement.h>

#include <list>

#include "csvreader.h"
#include "result.h"
#include <fstream>


using namespace std;

int main(void)
{
	setlocale(LC_ALL, "hungarian");

	std::list<Result> l;
	std::string name = "resz.csv";
	read(name, l);

	int version;
	ifstream versionfile1("version.txt");
	versionfile1 >> version;
	version++;
	versionfile1.close();
	ofstream versionfile2("version.txt");
	versionfile2 << version;
	versionfile2.close();

		try {
		sql::Driver *driver;
		sql::Connection *con;
		sql::Statement *stmt;

		driver = get_driver_instance();
		con = driver->connect("tcp://127.0.0.1:3306", "root", "tajfutas");
		con->setSchema("tajfutas");
		
		stmt = con->createStatement();

		stmt->execute("SET CHARACTER SET latin2");

		for each (Result r in l)
		{
			//std::cout << "v";
			stringstream s;
			s << "INSERT INTO verseny_2 (version,lastname, firstname, club, category, status, start,finish,time";
			for (int i = 0; r.checknr[i]; i++)s << ',' << "check" << (i + 1) << ',' << "checknr" << (i + 1);
			s << ") VALUES(" << version << ',';
			s << "\"" << r.lastname << "\"," << "\"" << r.firstname << "\"," << "\"" << r.club << "\"," << "\"" << r.category << "\"," << (int)r.status << ',' << r.start << ',' << r.finish << ',' << r.time;
			for (int i = 0; r.checknr[i]; i++)s << ',' << r.check[i] << ',' << (int)r.checknr[i];
			s << ") ON DUPLICATE KEY UPDATE ";
			s << "category=\"" << r.category << "\",";
			s << "start=" << r.start << ',';
			s << "finish=" << r.finish << ',';
			s << "time=" << r.time << ',';
			s << "status=" << (int)r.status;
			for (int i = 0; r.checknr[i]; i++)s << ',' << "check" << (i + 1) <<  '=' << r.check[i] << ',' << "checknr" << (i + 1) << '=' << (int)r.checknr[i];
			//std::cout << s.str();
			stmt->execute(s.str());
			stringstream u;
			u << "UPDATE verseny_2 SET version=" << version << " WHERE lastname=\"" << r.lastname << "\" AND firstname=\"" << r.firstname << "\" AND club=\"" << r.club << "\" AND category=\"" << r.category << "\"";
			stmt->execute(u.str());

		}
		std::cout << "update completed" << std::endl;
		stringstream s;
		s << "DELETE FROM verseny_2 WHERE version<>" << version;
		stmt->execute(s.str());
		std::cout << "delete completed" << std::endl;

		delete stmt;
		delete con;


		//delete

	}
	catch (sql::SQLException &e) {
		cout << "# ERR: SQLException in " << __FILE__;
		cout << "(" << __FUNCTION__ << ") on line " << __LINE__ << endl;
		cout << "# ERR: " << e.what();
		cout << " (MySQL error code: " << e.getErrorCode();
		cout << ", SQLState: " << e.getSQLState() << " )" << endl;
	}

	cout << endl;

	return EXIT_SUCCESS;
}