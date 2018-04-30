#include "stdafx.h"
#include <stdlib.h>
#include <iostream>

#include "mysql_connection.h"

#include <cppconn/driver.h>
#include <cppconn/exception.h>
#include <cppconn/resultset.h>
#include <cppconn/statement.h>
#include <cppconn/prepared_statement.h>

#include <list>

#include "csvreader.h"
#include "result.h"
#include "config.h"
#include <fstream>
#include <atomic>
#include <thread>
#include <sys/stat.h>
#include <string>
#include <windows.h>


using namespace std;

inline bool exists_test3(const std::string& name) {
	struct stat buffer;
	return (stat(name.c_str(), &buffer) == 0);
}

atomic_int input=0, output = 2, up_count = 1, del_count=1, new_count=1;

void uploader() {
	try {
		std::list<Result> res, res2, updated, newbie, deleted;
		config c;
		sql::Driver *driver;
		sql::Connection *con;
		sql::Statement *stmt;

		std::string eredmenytabla = "nap_3", updatetabla = "updated_3", deletetabla = "deleted_3", futoktabla="futok";

		c.load("config.txt");
		c.ip = "tcp://" + c.ip + ":3306";
		output = 0;
		driver = get_driver_instance();
		con = driver->connect(c.ip, c.user, c.pass);
		con->setSchema(c.db);

		stmt = con->createStatement();

		stmt->execute("SET CHARACTER SET latin1");

		/*
		sql::PreparedStatement  *id_fetcher,*id_create,*insert_data,*update_data,*updated_db,*delete_data,*deleted_db;
		id_fetcher = con->prepareStatement("SELECT id FROM futok WHERE lastname=? AND firstname=? AND club=? AND category=?");
		id_create = con->prepareStatement("INSERT INTO futok (lastname,firstname,club,category) VALUES(?,?,?,?)");
		insert_data = con->prepareStatement("INSERT INTO ? VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		insert_data = con->prepareStatement("INSERT INTO ? VALUES(?,?)");

		insert_data->setString(1, "nap_1");
		update_data = con->prepareStatement("UPDATE ? SET start=? , finish=? , time=? , status=? ,check1=? , check2=? , check3=? , check4=? , check5=? , check6=? , check7=? , check8=? , check9=? , check10=? , check11=? , check12=? , check13=? , check14=? , check15=? , check16=? , check17=? , check18=? , check19=? , check20=? , check21=? , check22=? , check23=? , check24=? , check25=? , check26=? , check27=? , check28=? , check29=? , check30=? , check31=? , check32=? , check33=? , check34=? , check35=? , check36=? , check37=? , check38=? , check39=? , check40=? , check41=? , check42=? , check43=? , check44=? , check45=? , check46=? , check47=? , check48=? , check49=? , check50=? , check51=? , check52=? , check53=? , check54=? , check55=? , check56=? , check57=? , check58=? , check59=? , check60=? , check61=? , check62=? , check63=? , check64=? , checknr1=? , checknr2=? , checknr3=? , checknr4=? , checknr5=? , checknr6=? , checknr7=? , checknr8=? , checknr9=? , checknr10=? , checknr11=? , checknr12=? , checknr13=? , checknr14=? , checknr15=? , checknr16=? , checknr17=? , checknr18=? , checknr19=? , checknr20=? , checknr21=? , checknr22=? , checknr23=? , checknr24=? , checknr25=? , checknr26=? , checknr27=? , checknr28=? , checknr29=? , checknr30=? , checknr31=? , checknr32=? , checknr33=? , checknr34=? , checknr35=? , checknr36=? , checknr37=? , checknr38=? , checknr39=? , checknr40=? , checknr41=? , checknr42=? , checknr43=? , checknr44=? , checknr45=? , checknr46 = ? , checknr47 = ? , checknr48 = ? , checknr49 = ? , checknr50 = ? , checknr51 = ? , checknr52 = ? , checknr53 = ? , checknr54 = ? , checknr55 = ? , checknr56 = ? , checknr57 = ? , checknr58 = ? , checknr59 = ? , checknr60 = ? , checknr61 = ? , checknr62 = ? , checknr63 = ? , checknr64 = ? WHERE id=?");
		update_data->setString(1, "nap_1");
		updated_db = con->prepareStatement("INSERT INTO ? VALUES(?,?)");
		updated_db->setString(1, "updated_1");
		delete_data = con->prepareStatement("DELETE FROM ? WHERE id=?");
		delete_data->setString(1, "nap_1");
		deleted_db = con->prepareStatement("INSERT INTO ? VALUES(?,?)");
		deleted_db->setString(1, "deleted_1");
		*/
		output = 1;

		while (input) {
			switch (input) {
			case(2):
				//load from db
				try {
					sql::ResultSet  *ress;
					int counter;
					std::stringstream count;
					count << "SELECT COUNT(id) FROM " << eredmenytabla;
					stmt->execute(count.str());
					ress = stmt->getResultSet();
					while (ress->next())
						counter = ress->getInt(1);



					for (int i = 0; i < counter;i += 50) {
						std::stringstream fetcher;

						fetcher << "SELECT * FROM " << eredmenytabla << " WHERE 1 ORDER BY id LIMIT 50 OFFSET "<< i;
						stmt->execute(fetcher.str());
						ress = stmt->getResultSet();
						while (ress->next()) {
							Result r;
							r.id = ress->getInt(1);
							r.start = ress->getInt(2);
							r.finish = ress->getInt(3);
							r.time = ress->getInt(4);
							r.status = ress->getInt(5);
							for (int i = 0; i < 64; i++) {
								r.check[i] = ress->getInt(i + 7);
								r.checknr[i] = ress->getInt(i + 7 + 64);
							}
							res.push_back(r);
						}
					}

					for (auto it = res.begin(); it != res.end(); it++) {
						std::stringstream fetch2;
						fetch2 << "SELECT * FROM "<< futoktabla<<" WHERE id=" << it->id;
						stmt->execute(fetch2.str());
						ress = stmt->getResultSet();
						while (ress->next()) {
							it->lastname = ress->getString(3);
							it->firstname = ress->getString(4);
							it->club = ress->getString(5);
							it->category = ress->getString(2);
						}
					}

					//new_count, del_count, up_count
					std::stringstream new_c;
					new_c << "SELECT MAX(version) FROM " << eredmenytabla;
					stmt->execute(new_c.str());
					ress = stmt->getResultSet();
					while (ress->next()) 
						new_count = ress->getInt(1);

					std::stringstream del_c;
					del_c << "SELECT MAX(version) FROM " << deletetabla;
					stmt->execute(del_c.str());
					ress = stmt->getResultSet();
					while (ress->next())
						del_count = ress->getInt(1);

					std::stringstream up_c;
					up_c << "SELECT MAX(version) FROM " << updatetabla;
					stmt->execute(up_c.str());
					ress = stmt->getResultSet();
					while (ress->next())
						up_count = ress->getInt(1);
					


				}
				catch (sql::SQLException &e) {
					cout << "# ERR: SQLException in " << __FILE__;
					cout << "(" << __FUNCTION__ << ") on line " << __LINE__ << endl;
					cout << "# ERR: " << e.what();
					cout << " (MySQL error code: " << e.getErrorCode();
					cout << ", SQLState: " << e.getSQLState() << " )" << endl;
				}
				input = 1;
				break;
			case(1):
				switch (output) {
				case(1):
					//file watcher
					while (!exists_test3(c.file)) {
						std::cout << "nofile";
						Sleep(5000);
					}
					output = 2;
					break;
				case(2):
					read(c.file, res2, c.type);
					newbie.clear();
					deleted.clear();
					updated.clear();
					output = 3;
					break;
				case(3):
					//összehasonlítás
					for (auto it = res2.begin(); it != res2.end(); it++) {
						bool find = false;
						for (auto it2 = res.begin(); it2 != res.end() && !find; it2++) {
							if (*it == *it2) {
								find = true;
								if (*it < *it2)
									updated.push_back(*it);
							}
						}
						if (!find)
							newbie.push_back(*it);
					}
					if (res.size() != (res2.size() - newbie.size())) {
						for (auto it = res.begin(); it != res.end(); it++) {
							bool find = false;
							for (auto it2 = res2.begin(); it2 != res2.end() && !find; it2++) {
								if (*it == *it2)find = true;
							}
							if (!find)
								deleted.push_back(*it);
						}
					}
					res = res2;
					res2.clear();
					output = 4;
					break;
				case(4):
					try {
						if (con->isValid())while (!con->reconnect());
						sql::ResultSet  *ress;
						if (!newbie.empty())new_count++;
						for (auto it = newbie.begin(); it != newbie.end(); it++) {

							if (it->id == -1) {
								//get id from db or create
								//SELECT id FROM futok WHERE lastname=? AND firstname=? AND club=? AND category=?
								std::stringstream id_fetcher;
								//id_fetcher->setString(1, it->lastname);
								id_fetcher << "SELECT id FROM "<<futoktabla<<" WHERE lastname=\"" << it->lastname << "\" AND firstname=\"" << it->firstname << "\" AND club=\"" << it->club << "\" AND category=\"" << it->category << "\"";
								/*id_fetcher->setString(2, it->firstname);
								id_fetcher->setString(3, it->club);
								id_fetcher->setString(4, it->category);*/
								stmt->execute(id_fetcher.str());
								ress = stmt->getResultSet();
								while (ress->next()) {
									it->id = ress->getInt(1);
								}
								std::cout << it->id;
								if (it->id == -1) {
									//create;
									//INSERT INTO futok (lastname,firstname,club,category) VALUES(?,?,?,?)");
									std::stringstream id_create;
									id_create <<"INSERT INTO " << futoktabla << " (lastname,firstname,club,category) VALUES(\""<< it->lastname << "\", \"" << it->firstname << "\", \"" << it->club << "\", \"" << it->category << "\")";
									/*
									id_create->setString(1, it->lastname);
									id_create->setString(2, it->firstname);
									id_create->setString(3, it->club);
									id_create->setString(4, it->category);*/
									stmt->execute(id_create.str());
									stmt->execute(id_fetcher.str());
									ress = stmt->getResultSet();
									while (ress->next()) {
										it->id = ress->getInt(1);
									}
								}
							}
							//add
							//insert_data = con->prepareStatement("INSERT INTO ? VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
							std::stringstream insert_data;
							insert_data <<"INSERT INTO " << eredmenytabla << " VALUES(" << it->id << "," << it->start << "," << it->finish << "," << it->time << "," << (int)it->status << "," << new_count;
							for (int i = 0; i < 64; i++)
								insert_data << "," << it->check[i];
							for (int i = 0; i < 64; i++)
								insert_data << "," << (int)it->checknr[i];
							insert_data << ")";
							/*insert_data->setInt(2, it->id);
							insert_data->setInt(3, it->start);
							insert_data->setInt(4, it->finish);
							insert_data->setInt(5, it->time);
							insert_data->setInt(6, it->status);
							insert_data->setInt(7, new_count);
							for (int i = 0; i < 64; i++) {
								insert_data->setInt(i + 8, it->check[i]);
								insert_data->setInt(i + 72, it->checknr[i]);
							}*/

							stmt->execute(insert_data.str());
						}
					}
					catch (sql::SQLException &e) {
						cout << "# ERR: SQLException in " << __FILE__;
						cout << "(" << __FUNCTION__ << ") on line " << __LINE__ << endl;
						cout << "# ERR: " << e.what();
						cout << " (MySQL error code: " << e.getErrorCode();
						cout << ", SQLState: " << e.getSQLState() << " )" << endl;
					}
					//upload new
					output = 5;
					break;
				case(5):
					try {
						sql::ResultSet  *ress;
						if (!updated.empty())up_count++;
						for (auto it = updated.begin(); it != updated.end(); it++) {
							if (it->id == -1) {
								//get id from db or create
								//SELECT id FROM futok WHERE lastname=? AND firstname=? AND club=? AND category=?
								std::stringstream id_fetcher;
								//id_fetcher->setString(1, it->lastname);
								id_fetcher <<"SELECT id FROM " << futoktabla << " WHERE lastname=\""<< it->lastname << "\" AND firstname=\"" << it->firstname << "\" AND club=\"" << it->club << "\" AND category=\"" << it->category << "\"";
								/*id_fetcher->setString(2, it->firstname);
								id_fetcher->setString(3, it->club);
								id_fetcher->setString(4, it->category);*/
								stmt->execute(id_fetcher.str());
								ress = stmt->getResultSet();
								while (ress->next()) {
									it->id = ress->getInt(1);
								}
							}
							// update_data = con->prepareStatement("UPDATE ? SET start=? , finish=? , time=? , status=? ,check1=? , check2=? , check3=? , check4=? , check5=? , check6=? , check7=? , check8=? , check9=? , check10=? , check11=? , check12=? , check13=? , check14=? , check15=? , check16=? , check17=? , check18=? , check19=? , check20=? , check21=? , check22=? , check23=? , check24=? , check25=? , check26=? , check27=? , check28=? , check29=? , check30=? , check31=? , check32=? , check33=? , check34=? , check35=? , check36=? , check37=? , check38=? , check39=? , check40=? , check41=? , check42=? , check43=? , check44=? , check45=? , check46=? , check47=? , check48=? , check49=? , check50=? , check51=? , check52=? , check53=? , check54=? , check55=? , check56=? , check57=? , check58=? , check59=? , check60=? , check61=? , check62=? , check63=? , check64=? , checknr1=? , checknr2=? , checknr3=? , checknr4=? , checknr5=? , checknr6=? , checknr7=? , checknr8=? , checknr9=? , checknr10=? , checknr11=? , checknr12=? , checknr13=? , checknr14=? , checknr15=? , checknr16=? , checknr17=? , checknr18=? , checknr19=? , checknr20=? , checknr21=? , checknr22=? , checknr23=? , checknr24=? , checknr25=? , checknr26=? , checknr27=? , checknr28=? , checknr29=? , checknr30=? , checknr31=? , checknr32=? , checknr33=? , checknr34=? , checknr35=? , checknr36=? , checknr37=? , checknr38=? , checknr39=? , checknr40=? , checknr41=? , checknr42=? , checknr43=? , checknr44=? , checknr45=? , checknr46 = ? , checknr47 = ? , checknr48 = ? , checknr49 = ? , checknr50 = ? , checknr51 = ? , checknr52 = ? , checknr53 = ? , checknr54 = ? , checknr55 = ? , checknr56 = ? , checknr57 = ? , checknr58 = ? , checknr59 = ? , checknr60 = ? , checknr61 = ? , checknr62 = ? , checknr63 = ? , checknr64 = ? WHERE id=?");

							std::stringstream updated_data;
							updated_data <<"UPDATE "<< eredmenytabla <<" SET start="<< it->start << " , finish=" << it->finish << " , time=" << it->time << " , status=" << (int)it->status;
							for (int i = 0; i < 64; i++)
								updated_data << ", check" << i + 1 << "=" << it->check[i];
							for (int i = 0; i < 64; i++)
								updated_data << ", checknr" << i + 1 << "=" << (int)it->checknr[i];
							updated_data << " WHERE id=" << it->id;
							/*update_data->setInt(2, it->start);
							update_data->setInt(3, it->finish);
							update_data->setInt(4, it->time);
							update_data->setInt(5, it->status);
							for (int i = 0; i < 64; i++) {
								update_data->setInt(i + 6, it->check[i]);
								update_data->setInt(i + 70, it->checknr[i]);
							}
							update_data->execute();
							updated_db->setInt(2, it->id);
							updated_db->setInt(3, up_count);*/
							stmt->execute(updated_data.str());
							std::stringstream update_db;
							//	updated_db = con->prepareStatement("INSERT INTO ? VALUES(?,?)");
							update_db <<"INSERT INTO "<< updatetabla << " VALUES(" << it->id << " , " << up_count << ")";
							stmt->execute(update_db.str());
						}
					}
					catch (sql::SQLException &e) {
						cout << "# ERR: SQLException in " << __FILE__;
						cout << "(" << __FUNCTION__ << ") on line " << __LINE__ << endl;
						cout << "# ERR: " << e.what();
						cout << " (MySQL error code: " << e.getErrorCode();
						cout << ", SQLState: " << e.getSQLState() << " )" << endl;
					}
					//update changed
					output = 6;
					break;
				case(6):
					//clear deleted
					try {
						sql::ResultSet  *ress;
						if (!deleted.empty())del_count++;
						for (auto it = deleted.begin(); it != deleted.end(); it++) {
							if (it->id == -1) {
								//get id from db or create
								std::stringstream id_fetcher;
								//id_fetcher->setString(1, it->lastname);
								id_fetcher <<"SELECT id FROM " << futoktabla << " WHERE lastname=\""<< it->lastname << "\" AND firstname=\"" << it->firstname << "\" AND club=\"" << it->club << "\" AND category=\"" << it->category << "\"";
								/*id_fetcher->setString(2, it->firstname);
								id_fetcher->setString(3, it->club);
								id_fetcher->setString(4, it->category);*/
								stmt->execute(id_fetcher.str());
								ress = stmt->getResultSet();
								while (ress->next()) {
									it->id = ress->getInt(1);
								}
							}
							/*delete_data = con->prepareStatement("DELETE FROM ? WHERE id=?");
							delete_data->setString(1, "nap_1");
							deleted_db = con->prepareStatement("INSERT INTO ? VALUES(?,?)");
							deleted_db->setString(1, "deleted_1");*/
							std::stringstream delete_data;
							delete_data <<"DELETE FROM "<< eredmenytabla << " WHERE id=" << it->id;
							/*delete_data->setInt(2, it->id);
							delete_data->execute();*/
							stmt->execute(delete_data.str());

							std::stringstream delete_db;
							delete_db <<"INSERT INTO "<< deletetabla << " VALUES(" << it->id << " , " << del_count << ")";
							/*deleted_db->setInt(2, it->id);
							deleted_db->setInt(3, del_count);
							deleted_db->execute();*/
							stmt->execute(delete_db.str());
						}
					}
					catch (sql::SQLException &e) {
						cout << "# ERR: SQLException in " << __FILE__;
						cout << "(" << __FUNCTION__ << ") on line " << __LINE__ << endl;
						cout << "# ERR: " << e.what();
						cout << " (MySQL error code: " << e.getErrorCode();
						cout << ", SQLState: " << e.getSQLState() << " )" << endl;
					}
					output = 1;
					//input = 0;
					break;
				default:
					break;
				}
			default:
				break;
			}
			/*delete id_fetcher;
			delete id_create;
			delete insert_data;
			delete update_data;
			delete updated_db;
			delete delete_data;
			delete deleted_db;*/


		}
		delete con;
		delete stmt;
	}
	catch (sql::SQLException &e) {
		cout << "# ERR: SQLException in " << __FILE__;
		cout << "(" << __FUNCTION__ << ") on line " << __LINE__ << endl;
		cout << "# ERR: " << e.what();
		cout << " (MySQL error code: " << e.getErrorCode();
		cout << ", SQLState: " << e.getSQLState() << " )" << endl;
	}
}


int main(void)
{
	input = 2;
	//setlocale(LC_ALL, "hungarian");
	uploader();
	
	int i;
	cin >> i;
	
	cout << endl;

	return EXIT_SUCCESS;
}